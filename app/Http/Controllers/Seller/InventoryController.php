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
                $q->where('name', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('sku', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('description', 'ilike', '%' . $searchTerm . '%');
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

        // Get global categories (without shop_id) and local categories (with current shop_id)
        $globalCategories = Category::whereNull('shop_id')->orderBy('name')->get();
        $localCategories = Category::where('shop_id', $shop->id)->orderBy('name')->get();

        return view('seller.inventory.create', compact('globalCategories', 'localCategories'));
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
            'long_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'final_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'global_categories' => 'required|array|min:1',
            'global_categories.*' => 'exists:categories,id',
            'local_categories' => 'nullable|array',
            'local_categories.*' => 'exists:categories,id',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'default_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'specification' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_popular' => 'boolean',
        ]);

        // Validate that global categories exist and don't belong to any shop
        $globalCategoryIds = $validated['global_categories'];
        $validGlobalCategories = Category::whereIn('id', $globalCategoryIds)
                                        ->whereNull('shop_id')
                                        ->pluck('id')
                                        ->toArray();

        if (count($validGlobalCategories) !== count($globalCategoryIds)) {
            return back()->withErrors(['global_categories' => 'One or more selected global categories are invalid.'])
                        ->withInput();
        }

        // Validate local categories belong to current shop
        $localCategoryIds = $validated['local_categories'] ?? [];
        if (!empty($localCategoryIds)) {
            $validLocalCategories = Category::whereIn('id', $localCategoryIds)
                                           ->where('shop_id', $shop->id)
                                           ->pluck('id')
                                           ->toArray();

            if (count($validLocalCategories) !== count($localCategoryIds)) {
                return back()->withErrors(['local_categories' => 'One or more selected local categories are invalid.'])
                            ->withInput();
            }
        }

        // Generate SKU if not provided
        if (!$validated['sku']) {
            $validated['sku'] = strtoupper(substr($shop->name, 0, 3)) . '-' . strtoupper(Str::random(6));
        }

        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        $originalSlug = $validated['slug'];
        $counter = 1;

        // Ensure slug uniqueness
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['shop_id'] = $shop->id;

        // Convert tags and specification to arrays if provided
        if (isset($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        }

        if (isset($validated['specification'])) {
            $validated['specification'] = array_filter(array_map('trim', explode(',', $validated['specification'])));
        }

        // Remove category arrays from validated data
        $allCategoryIds = array_merge($globalCategoryIds, $localCategoryIds);
        unset($validated['global_categories'], $validated['local_categories']);

        // Create the product
        $product = Product::create($validated);

        // Attach all categories (global + local) to the product
        $product->categories()->attach($allCategoryIds);

        // Handle image uploads using existing relations

        // 1. Handle Default Image (required)
        if ($request->hasFile('default_image')) {
            $defaultImage = $request->file('default_image');
            $path = $defaultImage->store('products', 'public');

            // Create media record for default image using defaultImage() relation
            $product->media()->create([
                'file_name' => $path, // Store the path in file_name
                'mime_type' => $defaultImage->getMimeType(),
                'disk' => 'public',
                'collection_name' => 'default-image',
                'name' => 'default-image',
                'size' => $defaultImage->getSize(),
            ]);
        }

        // 2. Handle Hover Image (optional)
        if ($request->hasFile('hover_image')) {
            $hoverImage = $request->file('hover_image');
            $path = $hoverImage->store('products', 'public');

            // Create media record for hover image using hoverImage() relation
            $product->media()->create([
                'file_name' => $path, // Store the path in file_name
                'mime_type' => $hoverImage->getMimeType(),
                'disk' => 'public',
                'collection_name' => 'hover-image',
                'name' => 'hover-image',
                'size' => $hoverImage->getSize(),
            ]);
        }

        // 3. Handle Gallery Images (optional, multiple)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $galleryImage) {
                $path = $galleryImage->store('products', 'public');

                // Create media record for gallery image using images() relation
                $product->media()->create([
                    'file_name' => $path, // Store the path in file_name
                    'mime_type' => $galleryImage->getMimeType(),
                    'disk' => 'public',
                    'collection_name' => 'image',
                    'name' => 'gallery-image-' . ($index + 1),
                    'size' => $galleryImage->getSize(),
                ]);
            }
        }

        return redirect()->route('seller.products.create')->with('success', 'Product created successfully!');
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

        // Load product with media relations
        $product->load(['categories', 'variants', 'defaultImage', 'hoverImage', 'images']);

        // Get global categories (without shop_id) and local categories (with shop_id)
        $globalCategories = Category::whereNull('shop_id')->get();
        $localCategories = Category::where('shop_id', $shop->id)->get();

        return view('seller.inventory.edit', compact('product', 'globalCategories', 'localCategories'));
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
            'global_categories' => 'required|array|min:1',
            'global_categories.*' => 'exists:categories,id',
            'local_categories' => 'nullable|array',
            'local_categories.*' => 'exists:categories,id',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'default_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'brand' => 'nullable|string|max:100',
        ]);

        // Update slug if name changed
        if ($validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle Default Image Upload
        if ($request->hasFile('default_image')) {
            // Delete existing default image
            $existingDefaultImage = $product->defaultImage;
            if ($existingDefaultImage) {
                $existingDefaultImage->delete();
            }

            $product->addMediaFromRequest('default_image')
                    ->toMediaCollection('default-image');
        }

        // Handle Hover Image Upload
        if ($request->hasFile('hover_image')) {
            // Delete existing hover image
            $existingHoverImage = $product->hoverImage;
            if ($existingHoverImage) {
                $existingHoverImage->delete();
            }

            $product->addMediaFromRequest('hover_image')
                    ->toMediaCollection('hover-image');
        }

        // Handle Gallery Images Upload
        if ($request->hasFile('gallery_images')) {
            // Delete existing gallery images
            $existingGalleryImages = $product->images;
            foreach ($existingGalleryImages as $image) {
                $image->delete();
            }

            foreach ($request->file('gallery_images') as $file) {
                $product->addMedia($file)
                        ->toMediaCollection('image');
            }
        }

        // Remove category arrays from validated data before updating product
        $globalCategories = $validated['global_categories'];
        $localCategories = $validated['local_categories'] ?? [];
        unset($validated['global_categories'], $validated['local_categories']);
        unset($validated['default_image'], $validated['hover_image'], $validated['gallery_images']);

        $product->update($validated);

        // Sync categories (combine global and local categories)
        $allCategories = array_merge($globalCategories, $localCategories);
        $product->categories()->sync($allCategories);

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
