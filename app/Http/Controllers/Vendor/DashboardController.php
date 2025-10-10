<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $vendor = $user->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.setup');
        }

        if (!$vendor->is_approved) {
            return view('vendor.pending');
        }

        $stats = [
            'total_products' => $vendor->products()->count(),
            'active_products' => $vendor->products()->where('is_active', true)->count(),
            'total_orders' => OrderItem::where('vendor_id', $vendor->id)->count(),
            'pending_orders' => OrderItem::where('vendor_id', $vendor->id)
                ->whereHas('order', fn($q) => $q->where('status', 'pending'))
                ->count(),
            'total_revenue' => OrderItem::where('vendor_id', $vendor->id)
                ->whereHas('order', fn($q) => $q->where('payment_status', 'paid'))
                ->sum('total'),
            'recent_orders' => OrderItem::where('vendor_id', $vendor->id)
                ->with(['order.user', 'product'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('vendor.dashboard', compact('stats', 'vendor'));
    }

    public function pending()
    {
        return view('vendor.pending');
    }
}


