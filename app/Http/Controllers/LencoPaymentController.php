<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LencoPaymentController extends Controller
{
    public function showForm()
    {
        return view('lenco.pay');
    }

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['required', 'string'],
            'country' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'operator' => ['required', 'string', 'in:airtel,mtn,tnm'],
            'bearer' => ['nullable', 'in:merchant,customer'],
        ]);

        $reference = 'LENCO_' . Str::uuid()->toString();
        $transactionId = Transaction::generateTransactionId();

        // Normalize phone to E.164 format (digits only, no + prefix for Lenco)
        $countryDialMap = [
            'NG' => '234',
            'GH' => '233',
            'KE' => '254',
            'UG' => '256',
            'RW' => '250',
            'ZM' => '260',
        ];
        
        $rawPhone = (string) $validated['phone'];
        $digitsOnly = preg_replace('/\D/', '', $rawPhone);
        $countryCode = $countryDialMap[$validated['country']] ?? '';
        
        // Normalize to: countrycode + subscriber number (no + or leading zero)
        if (str_starts_with($digitsOnly, $countryCode)) {
            // Already has country code
            $normalizedPhone = $digitsOnly;
        } elseif (str_starts_with($digitsOnly, '0')) {
            // Local format with leading zero - remove it and add countrycode
            $normalizedPhone = $countryCode . substr($digitsOnly, 1);
        } else {
            // Assume it's subscriber number without country code
            $normalizedPhone = $countryCode . $digitsOnly;
        }

        $payload = [
            'amount' => (string) $validated['amount'],
            'currency' => $validated['currency'],
            'reference' => $reference,
            'phone' => $normalizedPhone,
            'operator' => strtolower($validated['operator']),
            'bearer' => $validated['bearer'] ?? 'merchant',
        ];

        $baseUrl = rtrim(config('services.lenco.base_url'), '/');
        $secretKey = config('services.lenco.secret_key');

        // Log payload for debugging
        \Log::info('Lenco initiate payload', ['payload' => $payload]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0',
            ])->post($baseUrl . '/collections/mobile-money', $payload);
        } catch (ConnectionException $e) {
            return back()->withErrors(['network' => 'Network error. Please try again.']);
        }

        // Log response for debugging
        \Log::info('Lenco initiate response', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        if (!$response->ok()) {
            $errorMessage = $response->json('message') ?? 'Failed to initiate payment.';
            $errorCode = $response->json('errorCode') ?? '';
            $fullError = $errorMessage . ($errorCode ? " (Code: $errorCode)" : '');
            
            \Log::error('Lenco initiate failed', [
                'error' => $fullError,
                'payload' => $payload,
                'response' => $response->json(),
            ]);
            
            return back()->withErrors(['api' => $fullError])->withInput();
        }

        $data = $response->json('data');
        
        if (!$data) {
            return back()->withErrors(['api' => 'No data returned from payment provider.'])->withInput();
        }
        
        $status = $data['status'] ?? 'pending';
        $collectionId = $data['id'] ?? null;

        // Create transaction record
        try {
            $transaction = Transaction::create([
                'transaction_id' => $transactionId,
                'reference' => $reference,
                'user_id' => Auth::id(),
                'payment_method' => 'mobile_money',
                'provider' => 'lenco',
                'amount' => $validated['amount'],
                'fee' => $data['fee'] ?? null,
                'bearer' => $data['bearer'] ?? $validated['bearer'] ?? 'customer',
                'source' => $data['source'] ?? 'api',
                'currency' => $validated['currency'],
                'status' => 'pending',
                'provider_status' => $status,
                'provider_reference' => $collectionId,
                'provider_data' => $data,
                'phone' => $normalizedPhone,
                'account_name' => $data['mobileMoneyDetails']['accountName'] ?? null,
                'operator' => $validated['operator'],
                'operator_transaction_id' => $data['mobileMoneyDetails']['operatorTransactionId'] ?? null,
                'country' => $validated['country'],
                'initiated_at' => isset($data['initiatedAt']) ? \Carbon\Carbon::parse($data['initiatedAt']) : now(),
                'completed_at' => isset($data['completedAt']) ? \Carbon\Carbon::parse($data['completedAt']) : null,
            ]);

            \Log::info('Transaction created', ['transaction_id' => $transaction->id, 'reference' => $reference]);
        } catch (\Exception $e) {
            \Log::error('Failed to create transaction', ['error' => $e->getMessage()]);
            return back()->withErrors(['api' => 'Failed to create transaction record.'])->withInput();
        }

        if ($status === 'otp-required') {
            return redirect()->route('lenco.otp.form', [
                'id' => $collectionId,
                'reference' => $data['reference'] ?? $reference,
            ])->with('info', 'Enter the OTP sent to the phone.');
        }

        if ($status === 'pay-offline') {
            return redirect()->route('lenco.status', [
                'id' => $collectionId,
                'reference' => $data['reference'] ?? $reference,
            ])->with('info', 'Authorize the payment on your phone.');
        }

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'reference' => $data['reference'] ?? $reference,
                'status' => $status,
                'message' => 'Payment initiated successfully'
            ]);
        }

        return redirect()->route('lenco.status', [
            'id' => $collectionId,
            'reference' => $data['reference'] ?? $reference,
        ]);
    }

    public function showOtpForm(Request $request, $reference)
    {
        return view('lenco.otp', [
            'id' => $request->query('id'),
            'reference' => $reference,
        ]);
    }

    public function submitOtp(Request $request, $reference)
    {
        $validated = $request->validate([
            'id' => ['required', 'string'],
            'otp' => ['required', 'string'],
        ]);
        
        // Add reference from route parameter
        $validated['reference'] = $reference;

        $baseUrl = rtrim(config('services.lenco.base_url'), '/');
        $secretKey = config('services.lenco.secret_key');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0',
            ])->post($baseUrl . '/collections/mobile-money/submit-otp', [
                'id' => $validated['id'],
                'otp' => $validated['otp'],
            ]);
        } catch (ConnectionException $e) {
            return back()->withErrors(['network' => 'Network error. Please try again.'])->withInput();
        }

        if (!$response->ok()) {
            return back()->withErrors(['api' => $response->json('message') ?? 'Failed to submit OTP.'])->withInput();
        }

        $data = $response->json('data');

        return redirect()->route('lenco.status', [
            'id' => $data['id'] ?? $validated['id'],
            'reference' => $data['reference'] ?? $validated['reference'],
        ]);
    }

    public function status(Request $request, $reference)
    {
        $validated = $request->validate([
            'id' => ['nullable', 'string'],
        ]);
        
        // Add reference from route parameter
        $validated['reference'] = $reference;

        $baseUrl = rtrim(config('services.lenco.base_url'), '/');
        $secretKey = config('services.lenco.secret_key');

        $queryPath = null;
        if (!empty($validated['reference'])) {
            $queryPath = '/collections/status/' . urlencode($validated['reference']);
        } elseif (!empty($validated['id'])) {
            $queryPath = '/collections/' . urlencode($validated['id']);
        }

        if ($queryPath === null) {
            return redirect()->route('lenco.form')->withErrors(['status' => 'Missing reference or id.']);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Accept' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0',
            ])->get($baseUrl . $queryPath);
        } catch (ConnectionException $e) {
            return back()->withErrors(['network' => 'Network error. Please try again.']);
        }

        if (!$response->ok()) {
            return back()->withErrors(['api' => $response->json('message') ?? 'Failed to fetch status.']);
        }

        $data = $response->json('data');

        // Find the transaction by reference
        $transaction = Transaction::where('reference', $validated['reference'])->first();
        
        if ($transaction) {
            // Update transaction with latest data
            $transaction->update([
                'provider_status' => $data['status'] ?? 'unknown',
                'provider_data' => $data,
                'processed_at' => now(),
                'fee' => $data['fee'] ?? $transaction->fee,
                'bearer' => $data['bearer'] ?? $transaction->bearer,
                'source' => $data['source'] ?? $transaction->source,
                'account_name' => $data['mobileMoneyDetails']['accountName'] ?? $transaction->account_name,
                'operator_transaction_id' => $data['mobileMoneyDetails']['operatorTransactionId'] ?? $transaction->operator_transaction_id,
                'initiated_at' => isset($data['initiatedAt']) ? \Carbon\Carbon::parse($data['initiatedAt']) : $transaction->initiated_at,
                'completed_at' => isset($data['completedAt']) ? \Carbon\Carbon::parse($data['completedAt']) : $transaction->completed_at,
            ]);

            // Check if payment is successful and create order
            if (isset($data['status']) && $data['status'] === 'successful') {
                $transaction->update(['status' => 'successful']);
                $order = $this->createOrderFromPayment($data, $transaction);
                if ($order) {
                    return redirect()->route('order.success', $order)->with('success', 'Payment successful! Your order has been placed.');
                }
            } elseif (isset($data['status']) && in_array($data['status'], ['failed', 'cancelled'])) {
                $transaction->update([
                    'status' => 'failed',
                    'failure_reason' => $data['reasonForFailure'] ?? 'Payment failed'
                ]);
            }
        }

        return view('lenco.status', ['data' => $data, 'transaction' => $transaction]);
    }

    private function createOrderFromPayment($paymentData, $transaction = null)
    {
        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = $this->getCartItems();
            
            if ($cartItems->isEmpty()) {
                \Log::warning('Attempted to create order with empty cart');
                return null;
            }

            // Get address from session
            $address = session('checkout_address');
            if (!$address) {
                \Log::warning('Attempted to create order without address in session');
                return null;
            }

            // Calculate totals
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $total = $subtotal; // No tax or shipping

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_status' => $transaction && $transaction->status === 'successful' ? 'paid' : 'pending',
                'payment_method' => 'mobile_money',
                'payment_reference' => $transaction ? $transaction->reference : ($paymentData['reference'] ?? $paymentData['id'] ?? null),
                'subtotal' => $subtotal,
                'tax' => 0,
                'shipping' => 0,
                'total' => $total,
                'shipping_address' => json_encode([
                    'name' => $address['shipping_name'],
                    'phone' => $address['shipping_phone'],
                    'address' => $address['shipping_address'],
                    'city' => $address['shipping_city'],
                    'state' => $address['shipping_state'],
                    'country' => $address['shipping_country'],
                    'postal_code' => $address['shipping_postal_code'],
                ]),
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'vendor_id' => $cartItem->product->vendor_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'total' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Update product quantity
                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            // Clear cart
            $cartItems->each->delete();

            // Clear address from session
            session()->forget('checkout_address');

            DB::commit();

            \Log::info('Order created successfully from Lenco payment', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_reference' => $order->payment_reference
            ]);

            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create order from Lenco payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_data' => $paymentData
            ]);
            return null;
        }
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('product')->get();
        }

        return Cart::where('session_id', session()->getId())->with('product')->get();
    }

    public function handleTimeout(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string',
        ]);

        $transaction = Transaction::where('reference', $validated['reference'])->first();
        
        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found']);
        }

        // If transaction is still pending after timeout, create order with pending status
        if ($transaction->status === 'pending') {
            $transaction->update([
                'status' => 'timeout',
                'failure_reason' => 'Payment timeout - no response from provider',
                'processed_at' => now(),
            ]);

            // Create order with pending payment status
            $order = $this->createOrderFromPayment($transaction->provider_data, $transaction);
            
            if ($order) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Order created with pending payment status',
                    'order_id' => $order->id
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Transaction already processed']);
    }
}


