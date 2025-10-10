<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $total = $subtotal; // No tax or shipping in cart

        // Transform cart items for Alpine.js
        $cartItemsData = $cartItems->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'image' => $item->product->main_image ?? 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&q=80',
                'slug' => $item->product->slug
            ];
        });

        return view('cart', compact('cartItems', 'cartItemsData', 'subtotal', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->quantity < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartData = [
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
        ];

        if (auth()->check()) {
            $cartData['user_id'] = auth()->id();
            $cartItem = Cart::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();
        } else {
            $cartData['session_id'] = session()->getId();
            $cartItem = Cart::where('session_id', session()->getId())
                ->where('product_id', $product->id)
                ->first();
        }

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($product->quantity < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create($cartData);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        try {
            $this->authorize('update', $cart);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            throw $e;
        }
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->product->quantity < $validated['quantity']) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not enough stock available.'], 400);
            }
            return back()->with('error', 'Not enough stock available.');
        }

        $cart->update($validated);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Cart updated!']);
        }
        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        try {
            $this->authorize('delete', $cart);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            throw $e;
        }
        
        $cart->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Item removed from cart!']);
        }
        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $this->getCartItems()->each->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Cart cleared!']);
        }
        return back()->with('success', 'Cart cleared!');
    }

    private function getCartItems()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id())->with('product')->get();
        }

        return Cart::where('session_id', session()->getId())->with('product')->get();
    }
}


