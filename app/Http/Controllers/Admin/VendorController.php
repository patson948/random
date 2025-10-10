<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::with('user', 'products');

        if ($request->search) {
            $query->where('shop_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('email', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->status === 'active') {
            $query->where('is_approved', true);
        } elseif ($request->status === 'pending') {
            $query->where('is_approved', false);
        }

        $vendors = $query->latest()->paginate(20);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['user', 'products.category', 'products.reviews']);
        
        // Get orders containing this vendor's products
        $orders = \App\Models\Order::whereHas('items', function($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        })->with(['user', 'items' => function($query) use ($vendor) {
            $query->where('vendor_id', $vendor->id);
        }])->latest()->take(10)->get();
        
        // Calculate statistics
        $stats = [
            'total_products' => $vendor->products->count(),
            'active_products' => $vendor->products->where('is_active', true)->count(),
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum(function($order) use ($vendor) {
                return $order->items->where('vendor_id', $vendor->id)->sum('total');
            }),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'avg_rating' => $vendor->products->avg(function($product) {
                return $product->reviews->avg('rating');
            }),
        ];
        
        return view('admin.vendors.show', compact('vendor', 'orders', 'stats'));
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'vendor',
            'is_active' => true,
        ]);

        $vendorData = [
            'shop_name' => $validated['shop_name'],
            'slug' => \Str::slug($validated['shop_name']),
            'description' => $validated['description'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'commission_rate' => $validated['commission_rate'] ?? 10,
            'is_approved' => true,
        ];

        if ($request->hasFile('logo')) {
            $vendorData['logo'] = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $vendorData['banner'] = $request->file('banner')->store('vendors/banners', 'public');
        }

        $user->vendor()->create($vendorData);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor created successfully!');
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load('user');
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $vendor->user_id,
            'shop_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'is_approved' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:2048',
        ]);

        $vendor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $vendorData = [
            'shop_name' => $validated['shop_name'],
            'slug' => \Str::slug($validated['shop_name']),
            'description' => $validated['description'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'commission_rate' => $validated['commission_rate'] ?? 10,
            'is_approved' => $validated['is_approved'] ?? $vendor->is_approved,
        ];

        if ($request->hasFile('logo')) {
            $vendorData['logo'] = $request->file('logo')->store('vendors/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $vendorData['banner'] = $request->file('banner')->store('vendors/banners', 'public');
        }

        $vendor->update($vendorData);

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated successfully!');
    }

    public function approve(Vendor $vendor)
    {
        $vendor->update(['is_approved' => true]);
        return back()->with('success', 'Vendor approved successfully!');
    }

    public function reject(Vendor $vendor)
    {
        $vendor->update(['is_approved' => false]);
        return back()->with('success', 'Vendor rejected!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->user->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor deleted successfully!');
    }
}
