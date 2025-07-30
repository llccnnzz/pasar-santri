<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ShopBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShopBankController extends Controller
{
    /**
     * Display a listing of the shop bank accounts.
     */
    public function index(Request $request)
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $query = ShopBank::where('shop_id', $shop->id);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('bank_name', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('bank_code', 'ilike', '%' . $searchTerm . '%')
                  ->orWhere('account_number', 'ilike', '%' . $searchTerm . '%');
            });
        }

        $bankAccounts = $query->latest()->paginate(20);

        return view('seller.bank-accounts.index', compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new bank account.
     */
    public function create()
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        return view('seller.bank-accounts.create');
    }

    /**
     * Store a newly created bank account in storage.
     */
    public function store(Request $request)
    {
        $shop = Auth::user()->shop;

        if (!$shop) {
            return redirect()->route('seller.dashboard')->with('error', 'Please setup your shop first.');
        }

        $validated = $request->validate([
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:255',
            'account_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('shop_banks')->where(function ($query) use ($shop) {
                    return $query->where('shop_id', $shop->id);
                }),
            ],
            'is_default' => 'nullable|boolean',
        ]);

        $validated['shop_id'] = $shop->id;
        $validated['is_default'] = $request->boolean('is_default');

        // If this is the first bank account, make it default
        if (!$shop->banks()->exists()) {
            $validated['is_default'] = true;
        }

        $bankAccount = ShopBank::create($validated);

        // If set as default, unset others
        if ($validated['is_default']) {
            $bankAccount->setAsDefault();
        }

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account added successfully!');
    }

    /**
     * Display the specified bank account.
     */
    public function show(ShopBank $bankAccount)
    {
        $shop = Auth::user()->shop;

        if (!$shop || $bankAccount->shop_id !== $shop->id) {
            abort(404);
        }

        return view('seller.bank-accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified bank account.
     */
    public function edit(ShopBank $bankAccount)
    {
        $shop = Auth::user()->shop;

        if (!$shop || $bankAccount->shop_id !== $shop->id) {
            abort(404);
        }

        return view('seller.bank-accounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified bank account in storage.
     */
    public function update(Request $request, ShopBank $bankAccount)
    {
        $shop = Auth::user()->shop;

        if (!$shop || $bankAccount->shop_id !== $shop->id) {
            abort(404);
        }

        $validated = $request->validate([
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:255',
            'account_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('shop_banks')->where(function ($query) use ($shop) {
                    return $query->where('shop_id', $shop->id);
                })->ignore($bankAccount->id),
            ],
            'is_default' => 'nullable|boolean',
        ]);

        $validated['is_default'] = $request->boolean('is_default');

        $bankAccount->update($validated);

        // If set as default, unset others
        if ($validated['is_default']) {
            $bankAccount->setAsDefault();
        }

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account updated successfully!');
    }

    /**
     * Remove the specified bank account from storage.
     */
    public function destroy(ShopBank $bankAccount)
    {
        $shop = Auth::user()->shop;

        if (!$shop || $bankAccount->shop_id !== $shop->id) {
            abort(404);
        }

        // Check if this is the default account and there are other accounts
        if ($bankAccount->is_default && $shop->banks()->count() > 1) {
            // Set another account as default
            $nextAccount = $shop->banks()
                              ->where('id', '!=', $bankAccount->id)
                              ->first();
            if ($nextAccount) {
                $nextAccount->setAsDefault();
            }
        }

        $bankAccount->delete();

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account deleted successfully!');
    }

    /**
     * Set the specified bank account as default.
     */
    public function setPrimary(ShopBank $bankAccount)
    {
        $shop = Auth::user()->shop;

        if (!$shop || $bankAccount->shop_id !== $shop->id) {
            abort(404);
        }

        $bankAccount->setAsDefault();

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account set as default successfully!');
    }
}
