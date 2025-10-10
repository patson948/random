<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = auth()->user()->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);
        
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load(['items.product.category', 'items.vendor']);
        
        return view('customer.orders.show', compact('order'));
    }
}

