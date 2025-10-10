<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (!$user->isVendor()) {
            abort(403, 'Access denied. Vendor privileges required.');
        }

        if (!$user->vendor) {
            return redirect()->route('vendor.setup')
                ->with('info', 'Please complete your vendor profile setup.');
        }

        if (!$user->vendor->is_approved) {
            return redirect()->route('vendor.pending')
                ->with('warning', 'Your vendor account is pending approval.');
        }

        return $next($request);
    }
}


