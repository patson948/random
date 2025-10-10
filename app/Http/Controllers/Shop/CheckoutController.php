<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $total = $subtotal; // No tax or shipping

        // Get saved addresses for authenticated users
        $savedAddresses = collect([]);
        if (Auth::check()) {
            $savedAddresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        }

        return view('checkout', compact('cartItems', 'subtotal', 'total', 'savedAddresses'));
    }

    public function saveAddress(Request $request)
    {
        \Log::info('Checkout saveAddress called', [
            'request_data' => $request->all(),
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id()
        ]);

        // Check if a saved address is selected
        $addressId = $request->input('address_id');
        $isSavedAddress = $addressId && $addressId !== 'new';
        
        $validationRules = [
            'address_id' => 'nullable|string',
        ];
        
        // Only require shipping fields if not using a saved address
        if (!$isSavedAddress) {
            $validationRules = array_merge($validationRules, [
                'shipping_name' => 'required|string|max:255',
                'shipping_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string|max:255',
                'shipping_state' => 'required|string|max:255',
                'shipping_country' => 'required|string|max:255',
                'shipping_postal_code' => 'nullable|string|max:20',
            ]);
        }

        // Add save address fields only for authenticated users
        if (Auth::check()) {
            $validationRules['save_address'] = 'nullable|boolean';
            $validationRules['address_label'] = 'nullable|string|max:255';
        }
        
        $validated = $request->validate($validationRules);

        try {
            // Handle saved address selection
            if ($isSavedAddress && Auth::check()) {
                $savedAddress = Address::where('id', $addressId)
                    ->where('user_id', Auth::id())
                    ->first();
                
                if ($savedAddress) {
                    $addressData = [
                        'shipping_name' => $savedAddress->name,
                        'shipping_phone' => $savedAddress->phone,
                        'shipping_address' => $savedAddress->address,
                        'shipping_city' => $savedAddress->city,
                        'shipping_state' => $savedAddress->state,
                        'shipping_country' => $savedAddress->country,
                        'shipping_postal_code' => $savedAddress->postal_code,
                    ];
                    
                    // Store address data in session for payment page
                    session(['checkout_address' => $addressData]);
                    
                    \Log::info('Saved address selected successfully', ['address_id' => $addressId]);
                    return response()->json(['success' => true, 'message' => 'Address selected successfully']);
                } else {
                    \Log::error('Saved address not found', ['address_id' => $addressId, 'user_id' => Auth::id()]);
                    return response()->json(['success' => false, 'message' => 'Selected address not found.']);
                }
            }
            
            // Handle new address
            $addressData = [
                'shipping_name' => $validated['shipping_name'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_country' => $validated['shipping_country'],
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? '',
            ];

            // Save new address if requested and user is authenticated
            if (Auth::check() && isset($validated['save_address']) && $validated['save_address']) {
                $address = Address::create([
                    'user_id' => Auth::id(),
                    'name' => $validated['shipping_name'],
                    'phone' => $validated['shipping_phone'],
                    'address' => $validated['shipping_address'],
                    'city' => $validated['shipping_city'],
                    'state' => $validated['shipping_state'],
                    'country' => $validated['shipping_country'],
                    'postal_code' => $validated['shipping_postal_code'] ?? '',
                    'label' => $validated['address_label'] ?? 'Home',
                    'is_default' => Auth::user()->addresses()->count() === 0, // First address is default
                ]);
                
                \Log::info('New address created successfully', ['address_id' => $address->id]);
            }

            // Store address data in session for payment page
            session(['checkout_address' => $addressData]);

            \Log::info('Address data stored in session successfully');
            return response()->json(['success' => true, 'message' => 'Address saved successfully']);

        } catch (\Exception $e) {
            \Log::error('Failed to save address', [
                'error' => $e->getMessage(), 
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to save address: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:card,bank_transfer,cash_on_delivery',
        ]);

        // Get address from session
        $address = session('checkout_address');
        if (!$address) {
            return redirect()->route('checkout.index')->with('error', 'Please provide shipping address first.');
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $total = $subtotal; // No tax or shipping

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
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

            return redirect()->route('order.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to place order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    private function getCartItems()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->with('product')->get();
        }

        return Cart::where('session_id', session()->getId())->with('product')->get();
    }
}