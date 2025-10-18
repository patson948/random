<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $itemCount = $cartItems->sum('quantity');

        return response()->json([
            'items' => $cartItems,
            'total' => round($total, 2),
            'count' => $itemCount,
            'item_count' => $itemCount, // For mobile app compatibility
            'cart_count' => $itemCount, // Alternative field name
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'message' => 'Product is not available',
            ], 400);
        }

        if ($product->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
            ], 400);
        }

        $cartItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Check if new total quantity exceeds stock
            if ($product->quantity < $newQuantity) {
                return response()->json([
                    'message' => 'Cannot add more items. Insufficient stock available',
                ], 400);
            }
            
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            $cartItem = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        $cartItem->load('product');

        // Get updated cart count
        $cartCount = Cart::where('user_id', $request->user()->id)->sum('quantity');

        return response()->json([
            'message' => 'Product added to cart',
            'item' => $cartItem,
            'cart_count' => $cartCount,
            'item_count' => $cartCount,
            'success' => true,
        ], 201);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->product->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
            ], 400);
        }

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        $cart->load('product');

        // Get updated cart count
        $cartCount = Cart::where('user_id', $request->user()->id)->sum('quantity');

        return response()->json([
            'message' => 'Cart updated',
            'item' => $cart,
            'cart_count' => $cartCount,
            'item_count' => $cartCount,
            'success' => true,
        ]);
    }

    public function remove(Request $request, Cart $cart)
    {
        if ($cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $cart->delete();

        // Get updated cart count
        $cartCount = Cart::where('user_id', $request->user()->id)->sum('quantity');

        return response()->json([
            'message' => 'Item removed from cart',
            'cart_count' => $cartCount,
            'item_count' => $cartCount,
            'success' => true,
        ]);
    }

    public function clear(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'item_count' => 0,
            'success' => true,
        ]);
    }

    public function count(Request $request)
    {
        $cartCount = Cart::where('user_id', $request->user()->id)->sum('quantity');

        return response()->json([
            'cart_count' => $cartCount,
            'item_count' => $cartCount,
            'count' => $cartCount,
        ]);
    }
}


