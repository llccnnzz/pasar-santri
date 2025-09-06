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
            'jne' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/jne.png',
            'pos' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/pos.png',
            'tiki' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/tiki.png',
            'anteraja' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/anteraja.png',
            'sicepat' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/sicepat.png',
            'jnt' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/jnt.png',
            'ninja' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/ninja.png',
            'lion' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/lion.png',
            'wahana' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/wahana.png',
            'sap' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/sap.png',
            'jet' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/jet.png',
            'rex' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/rex.png',
            'first' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/first.png',
            'ide' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/ide.png',
            'spx' => 'https://biteship.s3.ap-southeast-1.amazonaws.com/courier_logo/spx.png',
        ];
    }
}
