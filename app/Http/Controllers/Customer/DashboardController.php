<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        // Get orders with related data
        $orders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->take(5)
            ->get();
        
        // Calculate statistics
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'completed_orders' => $user->orders()->where('status', 'delivered')->count(),
            'total_spent' => $user->orders()->where('payment_status', 'paid')->sum('total'),
        ];
        
        // Get recent reviews
        $recentReviews = $user->reviews()
            ->with('product')
            ->latest()
            ->take(3)
            ->get();
        
        return view('customer.dashboard', compact('orders', 'stats', 'recentReviews'));
    }
}

