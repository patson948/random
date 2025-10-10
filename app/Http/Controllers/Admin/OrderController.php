<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.category', 'items.vendor.user']);
        
        // Calculate statistics
        $stats = [
            'items_count' => $order->items->count(),
            'unique_vendors' => $order->items->pluck('vendor_id')->unique()->count(),
            'total_quantity' => $order->items->sum('quantity'),
        ];
        
        return view('admin.orders.show', compact('order', 'stats'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed,refunded',
        ]);

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status ?? $order->payment_status,
        ]);

        return back()->with('success', 'Order status updated successfully!');
    }
}
