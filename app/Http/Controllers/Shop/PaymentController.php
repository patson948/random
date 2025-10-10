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

class PaymentController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Get address from session
        $address = session('checkout_address');
        if (!$address) {
            return redirect()->route('checkout.index')->with('error', 'Please provide shipping address first.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $total = $subtotal; // No tax or shipping

        return view('payment', compact('cartItems', 'subtotal', 'total', 'address'));
    }

    public function process(Request $request)
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
                'order_number' => 'ORD-' . strtoupper(uniqid()),
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
