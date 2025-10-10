<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(): View
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('customer.addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'label' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        auth()->user()->addresses()->create($validated);

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Address added successfully!');
    }

    public function edit(Address $address): View
    {
        // Ensure user can only edit their own addresses
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        return view('customer.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        // Ensure user can only update their own addresses
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'label' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address->update($validated);

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Address updated successfully!');
    }

    public function destroy(Address $address): RedirectResponse
    {
        // Ensure user can only delete their own addresses
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Address deleted successfully!');
    }

    public function setDefault(Address $address): RedirectResponse
    {
        // Ensure user can only update their own addresses
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->update(['is_default' => true]);

        return redirect()->route('customer.addresses.index')
            ->with('success', 'Default address updated!');
    }
}

