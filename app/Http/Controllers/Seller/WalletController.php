<?php

namespace App\Http\Controllers\Seller;

use App\Models\ShopBank;
use App\Models\ShopBalance;
use Illuminate\Http\Request;
use App\Models\ShopBalanceLog;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WalletWithdrawRequest;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $shop = auth()->user()->shop;

        // Get or create shop balance
        $balance = ShopBalance::firstOrCreate(
            ['shop_id' => $shop->id],
            [
                'balance' => 0.00,
                'pending_in' => 0.00,
                'pending_out' => 0.00,
            ]
        );

        // Get recent transactions (last 10)
        $recentTransactions = ShopBalanceLog::where('shop_id', $shop->id)
            ->with('shopBank')
            ->latest()
            ->limit(10)
            ->get();

        // Get bank accounts for withdrawal
        $bankAccounts = ShopBank::where('shop_id', $shop->id)->get();

        return view('seller.wallet.index', compact(
            'balance',
            'recentTransactions',
            'bankAccounts'
        ));
    }

    public function transactions(Request $request)
    {
        $shop = auth()->user()->shop;


        $query = ShopBalanceLog::where('shop_id', $shop->id)->with('shopBank');

        // Filter by transaction type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_range') && $request->date_range) {
            $dateRange = $request->date_range;
            switch ($dateRange) {
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case '3months':
                    $query->where('created_at', '>=', now()->subMonths(3));
                    break;
            }
        }

        $transactions = $query->latest()->paginate(20);

        return view('seller.wallet.transactions', compact('transactions'));
    }

    public function withdrawForm()
    {
        $shop = auth()->user()->shop;


        $balance = ShopBalance::where('shop_id', $shop->id)->first();
        $bankAccounts = ShopBank::where('shop_id', $shop->id)->get();

        if ($bankAccounts->isEmpty()) {
            return redirect()->route('seller.bank-accounts.create')
                ->with('error', 'Please add a bank account first before making a withdrawal.');
        }

        return view('seller.wallet.withdraw', compact('balance', 'bankAccounts'));
    }

    public function withdrawRequest(WalletWithdrawRequest $request)
    {
        $shop = auth()->user()->shop;

        $balance = ShopBalance::where('shop_id', $shop->id)->first();

        if (!$balance || $balance->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient available balance.']);
        }

        // Verify bank account belongs to this shop
        $bankAccount = ShopBank::where('id', $request->shop_bank_id)
            ->where('shop_id', $shop->id)
            ->first();

        if (!$bankAccount) {
            return back()->withErrors(['shop_bank_id' => 'Invalid bank account selected.']);
        }

        try {
            DB::transaction(function () use ($request, $shop, $balance, $bankAccount) {
                // Update balance
                $balance->decrement('balance', $request->amount);
                $balance->increment('pending_out', $request->amount);

                // Create withdrawal log
                ShopBalanceLog::create([
                    'shop_id' => $shop->id,
                    'type' => 'out',
                    'amount' => $request->amount,
                    'details' => [
                        'type' => 'withdrawal',
                        'note' => $request->note,
                        'bank_name' => $bankAccount->bank_name,
                        'bank_code' => $bankAccount->bank_code,
                        'account_number' => $bankAccount->account_number,
                    ],
                    'shop_bank_id' => $request->shop_bank_id,
                    'reference' => 'WD-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'status' => 'pending',
                ]);
            });

            return redirect()->route('seller.wallet.index')
                ->with('success', 'Withdrawal request submitted successfully. It will be processed within 1-3 business days.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to process withdrawal request. Please try again.']);
        }
    }

    public function withdrawHistory(Request $request)
    {
        $shop = auth()->user()->shop;


        $query = ShopBalanceLog::where('shop_id', $shop->id)
            ->where('type', 'out')
            ->with('shopBank');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->paginate(20);

        return view('seller.wallet.withdraw-history', compact('withdrawals'));
    }

    public function earnings(Request $request)
    {
        $shop = auth()->user()->shop;


        $query = ShopBalanceLog::where('shop_id', $shop->id)
            ->where('type', 'in');

        // Get earnings statistics
        $totalEarnings = $query->clone()->where('status', 'completed')->sum('amount');
        $pendingEarnings = $query->clone()->where('status', 'pending')->sum('amount');
        $thisMonthEarnings = $query->clone()
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Get recent earnings
        $recentEarnings = $query->clone()
            ->latest()
            ->limit(20)
            ->get();

        return view('seller.wallet.earnings', compact(
            'totalEarnings',
            'pendingEarnings',
            'thisMonthEarnings',
            'recentEarnings'
        ));
    }

    public function transactionDetails($id)
    {
        $shop = auth()->user()->shop;

        $transaction = ShopBalanceLog::where('shop_id', $shop->id)
            ->where('id', $id)
            ->with('shopBank')
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'transaction' => $transaction,
            'formatted_amount' => $transaction->formatted_amount,
            'formatted_date' => $transaction->created_at->format('d M Y H:i'),
        ]);
    }
}
