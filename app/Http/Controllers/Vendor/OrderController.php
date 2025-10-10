<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $query = OrderItem::where('vendor_id', $vendor->id)
            ->with(['order.user', 'product']);

        if ($request->filled('status')) {
            $query->whereHas('order', fn($q) => $q->where('status', $request->status));
        }

        $orderItems = $query->latest()->paginate(20);
        return view('vendor.orders.index', compact('orderItems'));
    }

    public function show(Order $order)
    {
        $vendor = auth()->user()->vendor;
        
        // Only show order items belonging to this vendor
        $order->load(['user', 'items' => function ($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id)->with('product');
        }]);

        if ($order->items->isEmpty()) {
            abort(404, 'Order not found.');
        }

        return view('vendor.orders.show', compact('order'));
    }
}


