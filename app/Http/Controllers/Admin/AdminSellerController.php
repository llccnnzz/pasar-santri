<?php

namespace App\Http\Controllers\Admin;

use App\Events\ShopSuspended;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('seller')
            ->with(['shop', 'kycApplications'])
            ->withCount(['products', 'orders']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                  ->orWhere('email', 'ILIKE', "%{$search}%")
                  ->orWhereHas('shop', function ($shopQuery) use ($search) {
                      $shopQuery->where('name', 'ILIKE', "%{$search}%")
                               ->orWhere('slug', 'ILIKE', "%{$search}%");
                  });
            });
        }

        // Status filters
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->whereHas('shop', function ($q) {
                              $q->where('is_suspended', false);
                          });
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'suspended':
                    $query->whereHas('shop', function ($q) {
                        $q->where('is_suspended', true);
                    });
                    break;
                case 'no_shop':
                    $query->doesntHave('shop');
                    break;
            }
        }

        // Sort functionality
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortBy === 'shop_name') {
            $query->leftJoin('shops', 'users.id', '=', 'shops.user_id')
                  ->orderBy('shops.name', $sortDirection)
                  ->select('users.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $sellers = $query->paginate(15)->withQueryString();

        // Statistics
        $statistics = [
            'total' => User::role('seller')->count(),
            'active' => User::role('seller')->count(),
            'inactive' => 0,
            'suspended' => User::role('seller')->whereHas('shop', function ($q) {
                $q->where('is_suspended', true);
            })->count(),
            'with_shops' => User::role('seller')->has('shop')->count(),
        ];

        return view('admin.sellers.index', compact('sellers', 'statistics'));
    }

    public function show(User $user)
    {
        $user->load([
            'shop.suspendedBy',
            'kycApplications' => function ($query) {
                $query->latest();
            },
            'products' => function ($query) {
                $query->take(5);
            },
            'orders' => function ($query) {
                $query->take(5);
            }
        ]);

        // Additional statistics for this seller
        $stats = [
            'total_products' => $user->products()->count(),
            'active_products' => $user->products()->where('status', 'active')->count(),
            'total_orders' => $user->orders()->count(),
            'completed_orders' => $user->orders()->where('status', 'completed')->count(),
            'total_revenue' => (clone $user->orders())->where('status', 'completed')->get()->sum('total_amount'),
        ];

        return view('admin.sellers.show', compact('user', 'stats'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_active' => 'boolean',
        ]);

        $user->update($request->only(['name', 'email', 'is_active']));

        return redirect()->back()->with('success', 'Seller updated successfully.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'success' => true,
            'message' => "Seller has been {$status} successfully.",
            'is_active' => $user->is_active
        ]);
    }

    public function showShop(User $user)
    {
        $user->load(['shop.suspendedBy']);

        if (!$user->shop) {
            return redirect()->route('admin.sellers.show', $user)
                           ->with('error', 'This seller does not have a shop yet.');
        }

        return view('admin.sellers.shop', compact('user'));
    }

    public function suspendShop(Request $request, User $user)
    {
        $request->validate([
            'suspended_reason' => 'required|string|max:1000',
        ]);

        if (!$user->shop) {
            return response()->json([
                'success' => false,
                'message' => 'This seller does not have a shop.'
            ], 400);
        }

        if ($user->shop->is_suspended) {
            return response()->json([
                'success' => false,
                'message' => 'Shop is already suspended.'
            ], 400);
        }

        DB::transaction(function () use ($request, $user) {
            $user->shop->update([
                'is_suspended' => true,
                'suspended_reason' => $request->suspended_reason,
                'suspended_at' => now(),
                'suspended_by' => Auth::id(),
            ]);

            // Fire the shop suspended event
            event(new ShopSuspended($user->shop, $request->suspended_reason, Auth::user()));

            // Log the suspension activity
            activity()
                ->performedOn($user->shop)
                ->causedBy(Auth::user())
                ->withProperties([
                    'reason' => $request->suspended_reason,
                    'seller_name' => $user->name,
                    'shop_name' => $user->shop->name,
                ])
                ->log('Shop suspended');
        });

        return response()->json([
            'success' => true,
            'message' => 'Shop has been suspended successfully.'
        ]);
    }

    public function unsuspendShop(Request $request, User $user)
    {
        if (!$user->shop) {
            return response()->json([
                'success' => false,
                'message' => 'This seller does not have a shop.'
            ], 400);
        }

        if (!$user->shop->is_suspended) {
            return response()->json([
                'success' => false,
                'message' => 'Shop is not suspended.'
            ], 400);
        }

        DB::transaction(function () use ($user) {
            $user->shop->update([
                'is_suspended' => false,
                'suspended_reason' => null,
                'suspended_at' => null,
                'suspended_by' => null,
            ]);

            // Log the unsuspension activity
            activity()
                ->performedOn($user->shop)
                ->causedBy(Auth::user())
                ->withProperties([
                    'seller_name' => $user->name,
                    'shop_name' => $user->shop->name,
                ])
                ->log('Shop unsuspended');
        });

        return response()->json([
            'success' => true,
            'message' => 'Shop has been unsuspended successfully.'
        ]);
    }
}
