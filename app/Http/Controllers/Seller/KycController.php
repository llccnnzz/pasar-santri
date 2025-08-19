<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\KycApplication;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\KycStoreRequest;
use App\Http\Requests\KycReapplicationUpdateRequest;

class KycController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kycApplications = KycApplication::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $hasApprovedKyc = $kycApplications->where('status', 'approved')->isNotEmpty();
        $latestApplication = $kycApplications->first();

        return view('seller.kyc.index', compact('kycApplications', 'hasApprovedKyc', 'latestApplication'));
    }

    public function create()
    {
        $user = Auth::user();

        // Check if user already has an approved KYC
        $approvedKyc = KycApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();

        if ($approvedKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You already have an approved KYC application.');
        }

        // Check if user has a pending or under review application
        $pendingKyc = KycApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review'])
            ->exists();

        if ($pendingKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You already have a KYC application under review.');
        }

        return view('seller.kyc.create');
    }

    public function store(KycStoreRequest $request)
    {
        $user = Auth::user();

        // Check if user already has pending/approved KYC
        $existingKyc = KycApplication::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'under_review', 'approved'])
            ->exists();

        if ($existingKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You already have a KYC application.');
        }

        $kycData = $request->only([
            'first_name', 'last_name', 'date_of_birth', 'gender', 'nationality',
            'address', 'city', 'state', 'postal_code', 'country', 'phone',
            'document_type', 'document_number', 'document_expiry_date', 'document_issued_country',
            'terms_accepted', 'privacy_accepted'
        ]);

        $kycData['user_id'] = $user->id;
        $kycData['status'] = 'pending';
        $kycData['ip_address'] = $request->ip();
        $kycData['user_agent'] = $request->userAgent();

        $kyc = KycApplication::create($kycData);

        // Upload document front
        if ($request->hasFile('document_front')) {
            $kyc->addMediaFromRequest('document_front')
                ->toMediaCollection('document_front');
        }

        // Upload document back (if required)
        if ($request->hasFile('document_back')) {
            $kyc->addMediaFromRequest('document_back')
                ->toMediaCollection('document_back');
        }

        // Upload selfie
        if ($request->hasFile('selfie')) {
            $kyc->addMediaFromRequest('selfie')
                ->toMediaCollection('selfie');
        }

        // Upload additional documents
        if ($request->hasFile('additional_docs')) {
            foreach ($request->file('additional_docs') as $file) {
                $kyc->addMedia($file)
                    ->toMediaCollection('additional_docs');
            }
        }

        return redirect()->route('kyc.index')
            ->with('success', 'KYC application submitted successfully. It will be reviewed within 3-5 business days.');
    }

    public function show(KycApplication $kyc)
    {
        $this->authorize('view', $kyc);

        return view('seller.kyc.show', compact('kyc'));
    }

    public function reapply(KycApplication $kyc)
    {
        $this->authorize('reapply', $kyc);

        if ($kyc->status !== 'rejected') {
            return redirect()->route('kyc.index')
                ->with('error', 'You can only reapply for rejected applications.');
        }

        return view('seller.kyc.reapply', compact('kyc'));
    }

    public function updateReapplication(KycReapplicationUpdateRequest $request, KycApplication $kyc)
    {
        $this->authorize('reapply', $kyc);

        if ($kyc->status !== 'rejected') {
            return redirect()->route('kyc.index')
                ->with('error', 'You can only reapply for rejected applications.');
        }


        $kycData = $request->only([
            'first_name', 'last_name', 'date_of_birth', 'gender', 'nationality',
            'address', 'city', 'state', 'postal_code', 'country', 'phone',
            'document_type', 'document_number', 'document_expiry_date', 'document_issued_country',
            'terms_accepted', 'privacy_accepted'
        ]);

        $kycData['status'] = 'pending';
        $kycData['reviewed_by'] = null;
        $kycData['reviewed_at'] = null;
        $kycData['rejection_reason'] = null;
        $kycData['admin_notes'] = null;
        $kycData['ip_address'] = $request->ip();
        $kycData['user_agent'] = $request->userAgent();

        $kyc->update($kycData);

        // Update document files if uploaded
        if ($request->hasFile('document_front')) {
            $kyc->clearMediaCollection('document_front');
            $kyc->addMediaFromRequest('document_front')
                ->toMediaCollection('document_front');
        }

        if ($request->hasFile('document_back')) {
            $kyc->clearMediaCollection('document_back');
            $kyc->addMediaFromRequest('document_back')
                ->toMediaCollection('document_back');
        }

        if ($request->hasFile('selfie')) {
            $kyc->clearMediaCollection('selfie');
            $kyc->addMediaFromRequest('selfie')
                ->toMediaCollection('selfie');
        }

        if ($request->hasFile('additional_docs')) {
            $kyc->clearMediaCollection('additional_docs');
            foreach ($request->file('additional_docs') as $file) {
                $kyc->addMedia($file)
                    ->toMediaCollection('additional_docs');
            }
        }

        return redirect()->route('kyc.index')
            ->with('success', 'KYC application resubmitted successfully. It will be reviewed within 3-5 business days.');
    }
}
