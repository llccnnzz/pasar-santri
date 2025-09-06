<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminKycController extends Controller
{
    /**
     * Display a listing of KYC applications
     */
    public function index(Request $request)
    {
        $query = KycApplication::with(['user'])
            ->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 1
                    WHEN 'approved' THEN 2
                    WHEN 'rejected' THEN 3
                    ELSE 4
                END
            ");

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('document_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $kycApplications = $query->paginate(15);

        // Get statistics for the status tabs
        $statistics = [
            'total' => KycApplication::count(),
            'pending' => KycApplication::pending()->count(),
            'approved' => KycApplication::approved()->count(),
            'rejected' => KycApplication::rejected()->count(),
        ];

        return view('admin.kyc.index', compact('kycApplications', 'statistics'));
    }

    /**
     * Display the specified KYC application
     */
    public function show(KycApplication $kycApplication)
    {
        $kycApplication->load(['user', 'reviewer']);

        return view('admin.kyc.show', compact('kycApplication'));
    }

    /**
     * Approve a KYC application
     */
    public function approve(Request $request, KycApplication $kycApplication)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $kycApplication->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
                'rejection_reason' => null, // Clear any previous rejection reason
            ]);

            // Assign seller role to the user if not already assigned
            $user = $kycApplication->user;
            if (!$user->hasRole('seller')) {
                $user->assignRole('seller');
            }

            DB::commit();

            return redirect()
                ->route('admin.kyc.show', $kycApplication)
                ->with('success', 'KYC application has been approved successfully. User has been granted seller privileges.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Failed to approve KYC application. Please try again.');
        }
    }

    /**
     * Reject a KYC application
     */
    public function reject(Request $request, KycApplication $kycApplication)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $kycApplication->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'admin_notes' => $request->admin_notes,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

            // Remove seller role from user if they have it
            $user = $kycApplication->user;
            if ($user->hasRole('seller')) {
                $user->removeRole('seller');
            }

            DB::commit();

            return redirect()
                ->route('admin.kyc.show', $kycApplication)
                ->with('success', 'KYC application has been rejected. User has been notified.');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Failed to reject KYC application. Please try again.');
        }
    }

    /**
     * Get pending KYC applications count (for notifications)
     */
    public function pendingCount()
    {
        $count = KycApplication::pending()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Bulk action for multiple KYC applications
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'kyc_ids' => 'required|array|min:1',
            'kyc_ids.*' => 'exists:kyc_applications,id',
            'rejection_reason' => 'required_if:action,reject|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            $kycApplications = KycApplication::whereIn('id', $request->kyc_ids)->get();
            $successCount = 0;

            foreach ($kycApplications as $kyc) {
                switch ($request->action) {
                    case 'approve':
                        if ($kyc->status === 'pending') {
                            $kyc->update([
                                'status' => 'approved',
                                'admin_notes' => $request->admin_notes,
                                'reviewed_by' => Auth::id(),
                                'reviewed_at' => now(),
                                'rejection_reason' => null,
                            ]);

                            // Assign seller role
                            if (!$kyc->user->hasRole('seller')) {
                                $kyc->user->assignRole('seller');
                            }
                            $successCount++;
                        }
                        break;

                    case 'reject':
                        if ($kyc->status === 'pending') {
                            $kyc->update([
                                'status' => 'rejected',
                                'rejection_reason' => $request->rejection_reason,
                                'admin_notes' => $request->admin_notes,
                                'reviewed_by' => Auth::id(),
                                'reviewed_at' => now(),
                            ]);

                            // Remove seller role
                            if ($kyc->user->hasRole('seller')) {
                                $kyc->user->removeRole('seller');
                            }
                            $successCount++;
                        }
                        break;

                    case 'delete':
                        if (in_array($kyc->status, ['rejected', 'approved'])) {
                            $kyc->delete();
                            $successCount++;
                        }
                        break;
                }
            }

            DB::commit();

            $actionText = [
                'approve' => 'approved',
                'reject' => 'rejected',
                'delete' => 'deleted'
            ];

            return redirect()
                ->back()
                ->with('success', "{$successCount} KYC applications have been {$actionText[$request->action]} successfully.");

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Failed to perform bulk action. Please try again.');
        }
    }
}
