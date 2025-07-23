<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $query = Product::where('shop_id', $shop->id)->with(['categories', 'variants']);

        // Search functionality - search in name, sku, and description
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $query->latest()->paginate(10);

        return view('seller.inventory.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $categories = Category::where('shop_id', $shop->id)->get();
        
        return view('seller.inventory.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
        ]);

        // Generate SKU if not provided
        if (!$validated['sku']) {
            $validated['sku'] = strtoupper(substr($shop->name, 0, 3)) . '-' . strtoupper(Str::random(6));
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);
        $validated['shop_id'] = $shop->id;

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }
        $validated['images'] = json_encode($images);

        // Remove category_id from validated data before creating product
        $categoryId = $validated['category_id'];
        unset($validated['category_id']);

        $product = Product::create($validated);

        // Attach the category to the product
        $product->categories()->attach($categoryId);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $product->load(['images', 'categories', 'variants']);
        
        return view('seller.inventory.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $categories = Category::where('shop_id', $shop->id)->get();
        $product->load(['categories', 'variants']);
        
        return view('seller.inventory.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
        ]);

        // Update slug if name changed
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            $oldImages = json_decode($product->images, true) ?? [];
            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            // Upload new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $validated['images'] = json_encode($images);
        }

        // Remove category_id from validated data before updating product
        $categoryId = $validated['category_id'];
        unset($validated['category_id']);

        $product->update($validated);

        // Sync the category (this will replace any existing categories)
        $product->categories()->sync([$categoryId]);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        // Delete product images
        $images = json_decode($product->images, true) ?? [];
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }

        // Delete product variants
        $product->variants()->delete();

        // Delete the product
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Add a variant to the specified product.
     */
    public function addVariant(Request $request, Product $product)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:product_variants,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'attributes' => 'nullable|array',
        ]);

        // Generate SKU if not provided
        if (!$validated['sku']) {
            $validated['sku'] = $product->sku . '-' . strtoupper(Str::random(4));
        }

        $validated['product_id'] = $product->id;
        $validated['attributes'] = json_encode($validated['attributes'] ?? []);

        ProductVariant::create($validated);

        return redirect()->route('seller.products.show', $product)->with('success', 'Product variant added successfully!');
    }

    /**
     * Remove the specified variant from storage.
     */
    public function removeVariant(ProductVariant $variant)
    {
        $shop = Auth::user()->shop;
        $product = $variant->product;
        
        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $variant->delete();

        return redirect()->route('seller.products.show', $product)->with('success', 'Product variant removed successfully!');
    }

    /**
     * Update product status (bulk action).
     */
    public function bulkStatusUpdate(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'status' => 'required|in:active,inactive',
        ]);

        Product::where('shop_id', $shop->id)
            ->whereIn('id', $validated['product_ids'])
            ->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Products status updated successfully!']);
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $products = Product::where('shop_id', $shop->id)
            ->whereIn('id', $validated['product_ids'])
            ->get();

        foreach ($products as $product) {
            // Delete product images
            $images = json_decode($product->images, true) ?? [];
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            // Delete product variants
            $product->variants()->delete();

            // Delete the product
            $product->delete();
        }

        return response()->json(['message' => 'Products deleted successfully!']);
    }
}
