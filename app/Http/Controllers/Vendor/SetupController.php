<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SetupController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        if ($user->vendor) {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendor.setup');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255|unique:vendors,shop_name',
            'description' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $user = auth()->user();

        // Create vendor profile
        $vendor = Vendor::create([
            'user_id' => $user->id,
            'shop_name' => $validated['shop_name'],
            'slug' => Str::slug($validated['shop_name']),
            'description' => $validated['description'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'commission_rate' => 10.00, // Default commission rate
            'is_approved' => false, // Requires admin approval
        ]);

        return redirect()->route('vendor.pending')
            ->with('success', 'Your vendor application has been submitted successfully! We will review it and notify you within 1-2 business days.');
    }
}
