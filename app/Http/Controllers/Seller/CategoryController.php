<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the seller categories.
     */
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $query = Category::where('shop_id', $shop->id);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('slug', 'like', '%' . $searchTerm . '%');
            });
        }

        $categories = $query->latest()->paginate(20);

        return view('seller.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        return view('seller.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,shop_id,' . $shop->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        // Generate slug if not provided
        if (!$validated['slug']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug uniqueness for this shop
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('shop_id', $shop->id)->where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['shop_id'] = $shop->id;

        Category::create($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $category->shop_id !== $shop->id) {
            abort(404);
        }

        $productsCount = $category->products()->where('shop_id', $shop->id)->count();

        return view('seller.categories.show', compact('category', 'productsCount'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $category->shop_id !== $shop->id) {
            abort(404);
        }

        return view('seller.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $category->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,shop_id,' . $shop->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        // Generate slug if not provided or name changed
        if (!$validated['slug'] || $validated['name'] !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug uniqueness for this shop (exclude current category)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('shop_id', $shop->id)
                      ->where('slug', $validated['slug'])
                      ->where('id', '!=', $category->id)
                      ->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category->update($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $category->shop_id !== $shop->id) {
            abort(404);
        }

        // Check if category has products
        $productsCount = $category->products()->where('shop_id', $shop->id)->count();
        
        if ($productsCount > 0) {
            return redirect()->route('seller.categories.index')
                           ->with('error', 'Cannot delete category. It has ' . $productsCount . ' products associated with it.');
        }

        $category->delete();

        return redirect()->route('seller.categories.index')->with('success', 'Category deleted successfully!');
    }
}
