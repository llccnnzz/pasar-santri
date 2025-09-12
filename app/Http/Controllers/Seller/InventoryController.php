<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryAddVariantRequest;
use App\Http\Requests\InventoryBulkDeleteRequest;
use App\Http\Requests\InventoryBulkStatusUpdateRequest;
use App\Http\Requests\InventoryStoreRequest;
use App\Http\Requests\InventoryUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $shop = auth()->user()->shop;

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

    public function create()
    {
        $shop = auth()->user()->shop;

        // Get global categories (without shop_id) and local categories (with current shop_id)
        $globalCategories = Category::whereNull('shop_id')->orderBy('name')->get();
        $localCategories = Category::where('shop_id', $shop->id)->orderBy('name')->get();

        return view('seller.inventory.create', compact('globalCategories', 'localCategories'));
    }

    public function store(InventoryStoreRequest $request)
    {
        $shop = auth()->user()->shop;
        $validated = $request->validated();

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
            $product->addMedia($defaultImage)->preservingOriginal()
                    ->toMediaCollection('default-image');
        }

        // 2. Handle Hover Image (optional)
        if ($request->hasFile('hover_image')) {
            $hoverImage = $request->file('hover_image');
            $path = $hoverImage->store('products', 'public');

            // Create media record for hover image using hoverImage() relation
            $product->addMedia($hoverImage)->preservingOriginal()
                    ->toMediaCollection('hover-image');
        }

        // 3. Handle Gallery Images (optional, multiple)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $galleryImage) {
                $path = $galleryImage->store('products', 'public');

                // Create media record for gallery image using images() relation
                $product->addMedia($galleryImage)->preservingOriginal()
                        ->toMediaCollection('image');
            }
        }

        return redirect()->route('seller.products.create')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $product->load(['images', 'categories', 'variants']);

        return view('seller.inventory.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $shop = auth()->user()->shop;

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

    public function update(InventoryUpdateRequest $request, Product $product)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validated();

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

    public function destroy(Product $product)
    {
        $shop = auth()->user()->shop;

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

    public function addVariant(InventoryAddVariantRequest $request, Product $product)
    {
        $shop = auth()->user()->shop;

        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validated();

        // Generate SKU if not provided
        if (!$validated['sku']) {
            $validated['sku'] = $product->sku . '-' . strtoupper(Str::random(4));
        }

        $validated['product_id'] = $product->id;
        $validated['attributes'] = json_encode($validated['attributes'] ?? []);

        ProductVariant::create($validated);

        return redirect()->route('seller.products.show', $product)->with('success', 'Product variant added successfully!');
    }

    public function removeVariant(ProductVariant $variant)
    {
        $shop = auth()->user()->shop;
        $product = $variant->product;

        if (!$shop || $product->shop_id !== $shop->id) {
            abort(404);
        }

        $variant->delete();

        return redirect()->route('seller.products.show', $product)->with('success', 'Product variant removed successfully!');
    }

    public function bulkStatusUpdate(InventoryBulkStatusUpdateRequest $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        Product::where('shop_id', $shop->id)
            ->whereIn('id', $request['product_ids'])
            ->update(['status' => $request['status']]);

        return response()->json(['message' => 'Products status updated successfully!']);
    }

    public function bulkDelete(InventoryBulkDeleteRequest $request)
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $products = Product::where('shop_id', $shop->id)
            ->whereIn('id', $request['product_ids'])
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
