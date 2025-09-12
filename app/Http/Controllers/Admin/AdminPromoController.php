<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPromoController extends Controller
{
    /**
     * Display a listing of promotions
     */
    public function index(Request $request): View
    {
        $query = Promotion::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->get('status');
            switch ($status) {
                case 'active':
                    $query->active()
                          ->where('starts_at', '<=', Carbon::now())
                          ->where('expires_at', '>=', Carbon::now())
                          ->where(function ($q) {
                              $q->whereNull('usage_limit')
                                ->orWhereRaw('used_count < usage_limit');
                          });
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'expired':
                    $query->where('expires_at', '<', Carbon::now());
                    break;
                case 'scheduled':
                    $query->where('starts_at', '>', Carbon::now());
                    break;
            }
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $promotions = $query->paginate(10)->appends($request->query());

        // Statistics
        $stats = [
            'total' => Promotion::count(),
            'active' => Promotion::available()->count(),
            'expired' => Promotion::where('expires_at', '<', Carbon::now())->count(),
            'scheduled' => Promotion::where('starts_at', '>', Carbon::now())->count(),
        ];

        return view('admin.promos.index', compact('promotions', 'stats'));
    }

    /**
     * Show the form for creating a new promotion
     */
    public function create(): View
    {
        return view('admin.promos.create');
    }

    /**
     * Store a newly created promotion
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'discount_value' => 'required|numeric|min:1000',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'required|date|after_or_equal:today',
            'expires_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ], [
            'code.unique' => 'This promo code already exists.',
            'expires_at.after' => 'Expiry date must be after start date.',
            'starts_at.after_or_equal' => 'Start date cannot be in the past.',
            'discount_value.min' => 'Discount value must be at least Rp1,000.',
        ]);

        $promotion = Promotion::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'discount_type' => 'fixed',
            'discount_value' => $request->discount_value,
            'minimum_order_amount' => $request->minimum_order_amount ?? 0,
            'usage_limit' => $request->usage_limit,
            'starts_at' => Carbon::parse($request->starts_at),
            'expires_at' => Carbon::parse($request->expires_at),
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Promotion created successfully.',
                'data' => $promotion
            ]);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promotion created successfully.');
    }

    /**
     * Display the specified promotion
     */
    public function show(Promotion $promotion): View
    {
        return view('admin.promos.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified promotion
     */
    public function edit(Promotion $promotion): View
    {
        return view('admin.promos.edit', compact('promotion'));
    }

    /**
     * Update the specified promotion
     */
    public function update(Request $request, Promotion $promotion): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code,' . $promotion->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'discount_value' => 'required|numeric|min:1000',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'required|date',
            'expires_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
        ], [
            'code.unique' => 'This promo code already exists.',
            'expires_at.after' => 'Expiry date must be after start date.',
            'discount_value.min' => 'Discount value must be at least Rp1,000.',
        ]);

        $promotion->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'discount_value' => $request->discount_value,
            'minimum_order_amount' => $request->minimum_order_amount ?? 0,
            'usage_limit' => $request->usage_limit,
            'starts_at' => Carbon::parse($request->starts_at),
            'expires_at' => Carbon::parse($request->expires_at),
            'is_active' => $request->boolean('is_active', true),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Promotion updated successfully.',
                'data' => $promotion
            ]);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promotion updated successfully.');
    }

    /**
     * Remove the specified promotion
     */
    public function destroy(Promotion $promotion)
    {
        try {
            $promotion->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Promotion deleted successfully.'
                ]);
            }

            return redirect()->route('admin.promos.index')
                ->with('success', 'Promotion deleted successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting promotion: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.promos.index')
                ->with('error', 'Error deleting promotion.');
        }
    }
}
