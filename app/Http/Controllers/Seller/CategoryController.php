<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;

        $query = Category::where('shop_id', $shop->id);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%');
            });
        }

        $categories = $query->latest()->paginate(20);

        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('seller.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $shop      = Auth::user()->shop;
        $validated = $request->validated();

        // Generate slug if not provided
        if (! $validated['slug']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug uniqueness for this shop
        $originalSlug = $validated['slug'];
        $counter      = 1;
        while (Category::where('shop_id', $shop->id)->where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['shop_id'] = $shop->id;

        Category::create($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $shop = Auth::user()->shop;

        if ($category->shop_id !== $shop->id) {
            abort(404);
        }

        $productsCount = $category->products()->where('shop_id', $shop->id)->count();

        return view('seller.categories.show', compact('category', 'productsCount'));
    }

    public function edit(Category $category)
    {
        $shop = Auth::user()->shop;

        if ($category->shop_id !== $shop->id) {
            abort(404);
        }

        return view('seller.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $shop = Auth::user()->shop;

        if ($category->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validated();

        // Generate slug if not provided or name changed
        if (! $validated['slug'] || $validated['name'] !== $category->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug uniqueness for this shop (exclude current category)
        $originalSlug = $validated['slug'];
        $counter      = 1;
        while (
            Category::where('shop_id', $shop->id)
                ->where('slug', $validated['slug'])
                ->where('id', '!=', $category->id)
                ->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category->update($validated);

        return redirect()->route('seller.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $shop = Auth::user()->shop;

        if ($category->shop_id !== $shop->id) {
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
