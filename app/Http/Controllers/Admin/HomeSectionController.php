<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = HomeSection::orderBy('type')->orderBy('order')->get();
        
        return view('admin.home-sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:hero_slide,cta_banner,top_bar',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gradient' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home-sections', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSection $homeSection)
    {
        return view('admin.home-sections.show', compact('homeSection'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSection $homeSection)
    {
        return view('admin.home-sections.edit', compact('homeSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'type' => 'required|in:hero_slide,cta_banner,top_bar',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'badge' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gradient' => 'nullable|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($homeSection->image) {
                $oldPath = str_replace('/storage/', '', $homeSection->image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('home-sections', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSection $homeSection)
    {
        // Delete image if exists
        if ($homeSection->image) {
            $path = str_replace('/storage/', '', $homeSection->image);
            Storage::disk('public')->delete($path);
        }

        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section deleted successfully!');
    }
}
