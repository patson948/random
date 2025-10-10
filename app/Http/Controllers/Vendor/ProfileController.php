<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function setup()
    {
        if (auth()->user()->vendor) {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendor.setup');
    }

    public function storeSetup(Request $request)
    {
        if (auth()->user()->vendor) {
            return redirect()->route('vendor.dashboard');
        }

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['shop_name']) . '-' . Str::random(6);
        $validated['is_approved'] = false;

        Vendor::create($validated);

        return redirect()->route('vendor.pending')
            ->with('success', 'Vendor account submitted for approval!');
    }

    public function edit()
    {
        $vendor = auth()->user()->vendor;
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function update(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $vendor->update($validated);

        return redirect()->route('vendor.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}


