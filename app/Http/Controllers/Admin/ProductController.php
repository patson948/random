<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'vendor:id,shop_name,slug', 
            'category:id,name,slug'
        ]);

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->category_id) {
            $query->byCategory($request->category_id);
        }

        if ($request->vendor_id) {
            $query->byVendor($request->vendor_id);
        }

        if ($request->status) {
            if ($request->status === 'active') {
                $query->active();
            } else {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(20);
        
        // Optimize: Only load needed columns for filters
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $vendors = Vendor::select('id', 'shop_name')->orderBy('shop_name')->get();

        return view('admin.products.index', compact('products', 'categories', 'vendors'));
    }

    public function show(Product $product)
    {
        $product->load(['vendor.user', 'category', 'reviews.user', 'orderItems.order']);
        
        // Calculate statistics
        $stats = [
            'total_sold' => $product->orderItems->sum('quantity'),
            'total_revenue' => $product->orderItems->sum('total'),
            'total_reviews' => $product->reviews->count(),
            'avg_rating' => $product->reviews->avg('rating') ?? 0,
            'pending_orders' => $product->orderItems()->whereHas('order', function($q) {
                $q->where('status', 'pending');
            })->count(),
        ];
        
        return view('admin.products.show', compact('product', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        $vendors = Vendor::where('is_approved', true)->get();
        return view('admin.products.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sku'] = $validated['sku'] ?? 'PRD-' . strtoupper(Str::random(8));

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $vendors = Vendor::where('is_approved', true)->get();
        return view('admin.products.edit', compact('product', 'categories', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
        // Check if this is a quick status update (only is_active field present)
        if ($request->has('is_active') && count($request->all()) <= 2) { // 2 because _token and _method are always present
            $product->update(['is_active' => $request->boolean('is_active')]);
            return redirect()->back()->with('success', 'Product status updated successfully!');
        }

        // Full product update
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
