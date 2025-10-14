<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Optimized query with selective column loading
        $orders = Order::withCommonRelations()
            ->latest()
            ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Optimized: Load only needed columns
        $order->load([
            'user:id,name,email,avatar',
            'items' => function ($query) {
                $query->with([
                    'product:id,name,slug,images,price',
                    'product.category:id,name,slug',
                    'vendor:id,shop_name,slug,logo',
                    'vendor.user:id,name,email'
                ]);
            }
        ]);
        
        // Calculate statistics (use loaded data to avoid additional queries)
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
