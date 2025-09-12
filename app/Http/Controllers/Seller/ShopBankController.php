<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopBankStoreRequest;
use App\Http\Requests\ShopBankUpdateRequest;
use App\Models\ShopBank;
use Illuminate\Http\Request;

class ShopBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $shop = auth()->user()->shop;

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

    public function create()
    {
        $shop = auth()->user()->shop;


        return view('seller.bank-accounts.create');
    }

    public function store(ShopBankStoreRequest $request)
    {
        $shop = auth()->user()->shop;


        $validated = $request->validated();

        $validated['shop_id'] = $shop->id;
        $validated['is_default'] = $request->boolean('is_default');

        // If this is the first bank account, make it default

        $bankAccount = ShopBank::create($validated);

        // If set as default, unset others
        if ($validated['is_default'] || ShopBank::where('shop_id', $shop['id'])->count() === 1) {
            $bankAccount->setAsDefault();
        }

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account added successfully!');
    }

    public function show(ShopBank $bankAccount)
    {
        $shop = auth()->user()->shop;


        return view('seller.bank-accounts.show', compact('bankAccount'));
    }

    public function edit(ShopBank $bankAccount)
    {
        $shop = auth()->user()->shop;


        return view('seller.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(ShopBankUpdateRequest $request, ShopBank $bankAccount)
    {
        $shop = auth()->user()->shop;


        $validated = $request->validated();

        $validated['is_default'] = $request->boolean('is_default');

        $bankAccount->update($validated);

        // If set as default, unset others
        if ($validated['is_default']) {
            $bankAccount->setAsDefault();
        }

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account updated successfully!');
    }

    public function destroy(ShopBank $bankAccount)
    {
        $shop = auth()->user()->shop;


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

    public function setPrimary(ShopBank $bankAccount)
    {
        $shop = auth()->user()->shop;


        $bankAccount->setAsDefault();

        return redirect()->route('seller.bank-accounts.index')
                        ->with('success', 'Bank account set as default successfully!');
    }
}
