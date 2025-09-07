<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminShippingController extends Controller
{
    public function index(Request $request)
    {
        $query = ShippingMethod::orderBy('courier_name')
            ->orderBy('service_name');

        if ($request->has('status') && $request->status !== '') {
            $active = $request->status === 'active';
            $query->where('active', $active);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('courier_name', 'like', "%{$search}%")
                  ->orWhere('service_name', 'like', "%{$search}%")
                  ->orWhere('courier_code', 'like', "%{$search}%")
                  ->orWhere('service_code', 'like', "%{$search}%");
            });
        }

        $allMethods = $query->get();

        // Group by courier_code
        $groupedMethods = $allMethods->groupBy('courier_code')->map(function ($methods, $courierCode) {
            $firstMethod = $methods->first();
            return [
                'courier_code' => $courierCode,
                'courier_name' => $firstMethod->courier_name,
                'logo_url' => $firstMethod->logo_url,
                'total_services' => $methods->count(),
                'active_services' => $methods->where('active', true)->count(),
                'inactive_services' => $methods->where('active', false)->count(),
                'all_active' => $methods->every('active'),
                'all_inactive' => $methods->every(fn($m) => !$m->active),
                'methods' => $methods
            ];
        });

        $statistics = [
            'total' => ShippingMethod::count(),
            'active' => ShippingMethod::where('active', true)->count(),
            'inactive' => ShippingMethod::where('active', false)->count(),
            'couriers' => ShippingMethod::distinct('courier_code')->count(),
        ];

        return view('admin.shipping.index', compact('groupedMethods', 'statistics'));
    }

    public function show(ShippingMethod $shippingMethod)
    {
        return view('admin.shipping.show', compact('shippingMethod'));
    }

    public function toggleStatus(Request $request, ShippingMethod $shippingMethod)
    {
        try {
            $shippingMethod->update([
                'active' => !$shippingMethod->active
            ]);

            $status = $shippingMethod->active ? 'activated' : 'deactivated';

            return redirect()
                ->back()
                ->with('success', "Shipping method has been {$status} successfully.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update shipping method status. Please try again.');
        }
    }

    public function toggleCourierStatus(Request $request, $courierCode)
    {
        $request->validate([
            'active' => 'required|string|in:true,false',
        ]);

        $active = $request->active === 'true';

        try {
            DB::beginTransaction();

            $updated = ShippingMethod::where('courier_code', $courierCode)
                ->update(['active' => $active]);

            DB::commit();

            $status = $active ? 'activated' : 'deactivated';
            $courier = ShippingMethod::where('courier_code', $courierCode)->first();

            return response()->json([
                'success' => true,
                'message' => "{$courier->courier_name} courier has been {$status} successfully. {$updated} services updated."
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update courier status. Please try again.'
            ], 500);
        }
    }

    public function syncFromApi(BiteshipService $biteship)
    {
        try {
            DB::beginTransaction();

            $response = $biteship->couriers();

            if (empty($response['couriers'])) {
                return redirect()
                    ->back()
                    ->with('error', 'No couriers found from Biteship API.');
            }

            $count = 0;
            $updated = 0;
            $logos = $this->getCourierLogos();

            foreach ($response['couriers'] as $courier) {
                $courierCode = $courier['courier_code'];
                $logoUrl = $logos[$courierCode] ?? null;

                $shippingMethod = ShippingMethod::updateOrCreate(
                    [
                        'courier_code' => $courierCode,
                        'service_code' => $courier['courier_service_code'],
                    ],
                    [
                        'courier_name' => $courier['courier_name'],
                        'service_name' => $courier['courier_service_name'] ?? '',
                        'description'  => $courier['description'] ?? null,
                        'logo_url'     => $logoUrl,
                        'active'       => true,
                    ]
                );

                if ($shippingMethod->wasRecentlyCreated) {
                    $count++;
                } else {
                    $updated++;
                }
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('success', "Successfully synced {$count} new and updated {$updated} existing shipping methods from Biteship API.");

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Failed to sync shipping methods from API. Please try again.');
        }
    }

    private function getCourierLogos(): array
    {
        return [
            "anteraja" => "/assets/imgs/courier-logo/anteraja.png",
            "borzo" => "/assets/imgs/courier-logo/borzo.jpeg",
            "deliveree" => "/assets/imgs/courier-logo/deliveree.jpeg",
            "gojek" => "/assets/imgs/courier-logo/gojek.png",
            "grab" => "/assets/imgs/courier-logo/grab.jpg",
            "idexpress" => "/assets/imgs/courier-logo/idexpress.png",
            "jne" => "/assets/imgs/courier-logo/jne.png",
            "jnt" => "/assets/imgs/courier-logo/jnt.png",
            "lalamove" => "/assets/imgs/courier-logo/lalamove.jpeg",
            "lion" => "/assets/imgs/courier-logo/lion.png",
            "ninja" => "/assets/imgs/courier-logo/ninja.png",
            "paxel" => "/assets/imgs/courier-logo/paxel.png",
            "pos" => "/assets/imgs/courier-logo/pos.png",
            "rpx" => "/assets/imgs/courier-logo/rpx.png",
            "sap" => "/assets/imgs/courier-logo/sapx.png",
            "sentralcargo" => "/assets/imgs/courier-logo/sentral.jpeg",
            "sicepat" => "/assets/imgs/courier-logo/sicepat.png",
            "tiki" => "/assets/imgs/courier-logo/tiki.png",
            "wahana" => "/assets/imgs/courier-logo/wahana.png",
        ];
    }
}
