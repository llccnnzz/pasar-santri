<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminAdsController extends Controller
{
    /**
     * Display a listing of product ads with tabs for each category
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', ProductAd::CATEGORY_FLASH_SALE);
        $status = $request->get('status');
        $search = $request->get('search');

        // Build query for ads with filters
        $query = ProductAd::with(['product', 'product.variants', 'product.media'])
                        ->byCategory($activeTab);

        // Apply status filter
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Apply search filter
        if ($search) {
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('sku', 'ILIKE', "%{$search}%");
            });
        }

        $ads = $query->ordered()->paginate(20);

        // Get statistics for all categories
        $statistics = [];
        foreach (ProductAd::CATEGORIES as $key => $name) {
            $statistics[$key] = [
                'total' => ProductAd::byCategory($key)->count(),
                'active' => ProductAd::byCategory($key)->active()->count(),
            ];
        }

        // Get auto-suggest products for auto-suggest categories
        $autoSuggestProducts = [];
        if (in_array($activeTab, [ProductAd::CATEGORY_BIG_DISCOUNT, ProductAd::CATEGORY_NEW_PRODUCT, ProductAd::CATEGORY_LESS_THAN_10K])) {
            $autoSuggestProducts = ProductAd::getAutoSuggestProducts($activeTab, 10);
        }

        return view('admin.ads.index', compact('ads', 'statistics', 'activeTab', 'autoSuggestProducts'));
    }

    /**
     * Show the form for creating a new product ad
     */
    public function create(Request $request)
    {
        $category = $request->get('category', ProductAd::CATEGORY_FLASH_SALE);

        // For auto-suggest categories, get suggested products
        $suggestedProducts = [];
        if (in_array($category, [ProductAd::CATEGORY_BIG_DISCOUNT, ProductAd::CATEGORY_NEW_PRODUCT, ProductAd::CATEGORY_LESS_THAN_10K])) {
            $suggestedProducts = ProductAd::getAutoSuggestProducts($category, 20);
        }

        // Get all active products for manual selection
        $products = Product::with(['variants', 'media'])
                          ->where('status', 'active')
                          ->orderBy('name')
                          ->get();

        return view('admin.ads.create', compact('category', 'suggestedProducts', 'products'));
    }

    /**
     * Store a newly created product ad
     */
    public function store(Request $request)
    {
        $rules = [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('product_ads')->where(function ($query) use ($request) {
                    return $query->where('category', $request->category);
                })
            ],
            'category' => ['required', Rule::in(array_keys(ProductAd::CATEGORIES))],
            'sort_order' => 'nullable|integer|min:0',
            'valid_until' => 'nullable|date|after:now',
            'is_active' => 'boolean',
            'submission_type' => ['required', Rule::in([ProductAd::SUBMISSION_TYPE_MANUAL, ProductAd::SUBMISSION_TYPE_AUTO_SUGGEST])],
            'admin_notes' => 'nullable|string|max:1000'
        ];

        // Flash sale requires valid_until
        if ($request->category === ProductAd::CATEGORY_FLASH_SALE) {
            $rules['valid_until'] = 'required|date|after:now';
        }

        // Hot promo requires sort_order
        if ($request->category === ProductAd::CATEGORY_HOT_PROMO) {
            $rules['sort_order'] = 'required|integer|min:0';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $productAd = ProductAd::create($validated);

            DB::commit();

            return redirect()->route('admin.ads.index', ['tab' => $productAd->category])
                           ->with('success', 'Product ad created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                        ->with('error', 'Failed to create product ad: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product ad
     */
    public function show(ProductAd $productAd)
    {
        $productAd->load(['product', 'product.variants', 'product.media']);

        return view('admin.ads.show', compact('productAd'));
    }

    /**
     * Show the form for editing the specified product ad
     */
    public function edit(ProductAd $productAd)
    {
        $productAd->load(['product', 'product.variants', 'product.media']);

        // Get all active products for manual selection
        $products = Product::with(['variants', 'media'])
                          ->where('status', 'active')
                          ->orderBy('name')
                          ->get();

        return view('admin.ads.edit', compact('productAd', 'products'));
    }

    /**
     * Update the specified product ad
     */
    public function update(Request $request, ProductAd $productAd)
    {
        $rules = [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('product_ads')->where(function ($query) use ($productAd) {
                    return $query->where('category', $productAd->category);
                })->ignore($productAd->id)
            ],
            'sort_order' => 'nullable|integer|min:0',
            'valid_until' => 'nullable|date|after:now',
            'is_active' => 'boolean',
            'admin_notes' => 'nullable|string|max:1000'
        ];

        // Flash sale requires valid_until
        if ($productAd->category === ProductAd::CATEGORY_FLASH_SALE) {
            $rules['valid_until'] = 'nullable|after:now';
        }

        // Hot promo requires sort_order
        if ($productAd->category === ProductAd::CATEGORY_HOT_PROMO) {
            $rules['sort_order'] = 'nullable|integer|min:0';
        }

        $validated = $request->validate($rules);

        $productAd->update($validated);

        return redirect()->back()->with('success', 'Product ad updated successfully!');
    }

    /**
     * Remove the specified product ad from storage
     */
    public function destroy(ProductAd $productAd)
    {
        try {
            $category = $productAd->category;
            $productAd->delete();

            return redirect()->route('admin.ads.index', ['tab' => $category])
                           ->with('success', 'Product ad deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product ad: ' . $e->getMessage());
        }
    }

    /**
     * Handle bulk actions on multiple product ads
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'ad_ids' => 'required|array|min:1',
            'ad_ids.*' => 'exists:product_ads,id',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $adIds = $request->ad_ids;
            $action = $request->action;
            $adminNotes = $request->admin_notes;
            $count = 0;

            switch ($action) {
                case 'activate':
                    $count = ProductAd::whereIn('id', $adIds)
                                   ->update([
                                       'is_active' => true,
                                       'admin_notes' => $adminNotes ?: 'Bulk activated',
                                       'updated_at' => now()
                                   ]);
                    break;

                case 'deactivate':
                    $count = ProductAd::whereIn('id', $adIds)
                                   ->update([
                                       'is_active' => false,
                                       'admin_notes' => $adminNotes ?: 'Bulk deactivated',
                                       'updated_at' => now()
                                   ]);
                    break;

                case 'delete':
                    $count = ProductAd::whereIn('id', $adIds)->count();
                    ProductAd::whereIn('id', $adIds)->delete();
                    break;
            }

            DB::commit();

            $actionText = match($action) {
                'activate' => 'activated',
                'deactivate' => 'deactivated',
                'delete' => 'deleted'
            };

            return redirect()->route('admin.ads.index')
                           ->with('success', "{$count} product ads {$actionText} successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Bulk action failed: ' . $e->getMessage());
        }
    }

    /**
     * Get auto-suggestions for a specific category via AJAX
     */
    public function autoSuggestions($category)
    {
        try {
            $products = ProductAd::getAutoSuggestProducts($category, 20);

            $suggestions = $products->map(function ($product) {
                $variant = $product->variants->first();
                $finalPrice = $variant ? ($variant->final_price ?? $variant->price) : 0;
                $originalPrice = $variant ? $variant->price : 0;
                $discount = $originalPrice > 0 && $finalPrice < $originalPrice
                    ? round((($originalPrice - $finalPrice) / $originalPrice) * 100, 1)
                    : 0;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => 'Rp' . number_format($finalPrice, 0, ',', '.'),
                    'discount' => $discount > 0 ? $discount . '%' : null,
                    'image' => $product->media->isNotEmpty()
                        ? $product->media->first()->getUrl()
                        : null
                ];
            });

            return response()->json([
                'success' => true,
                'suggestions' => $suggestions
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
