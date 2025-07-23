<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\BankAccount;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard(Request $request)
    {
        $seller = Auth::user();
        $shop = $seller->shop;
        
        // Dashboard statistics
        $stats = [
            'total_products' => $shop ? $shop->products()->count() : 0,
            'total_orders' => 0,
            'pending_orders' => 0,
            'total_earnings' => 0,
        ];
        
        return view('seller.dashboard', compact('stats'));
    }

    // Product & SKU Management
    public function productsList(Request $request)
    {
        $shop = Auth::user()->shop;
        $products = $shop ? $shop->products()->with('category', 'images')->paginate(15) : collect();
        return view('seller.products.index', compact('products'));
    }

    public function productsCreate()
    {
        $categories = Category::where('status', 'active')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function productsStore(Request $request)
    {
        // Implementation for product creation
        return redirect()->route('seller.products.index')->with('success', 'Product created successfully');
    }

    public function productsEdit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function productsUpdate(Request $request, Product $product)
    {
        // Implementation for product update
        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');
    }

    public function productsDestroy(Product $product)
    {
        // Implementation for product deletion
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully');
    }

    // Category Management
    public function categoriesList(Request $request)
    {
        $shop = Auth::user()->shop;
        $categories = $shop ? $shop->categories()->paginate(15) : collect();
        return view('seller.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('seller.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        // Implementation for category creation
        return redirect()->route('seller.categories.index')->with('success', 'Category created successfully');
    }

    public function categoriesEdit($category)
    {
        return view('seller.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, $category)
    {
        // Implementation for category update
        return redirect()->route('seller.categories.index')->with('success', 'Category updated successfully');
    }

    public function categoriesDestroy($category)
    {
        // Implementation for category deletion
        return redirect()->route('seller.categories.index')->with('success', 'Category deleted successfully');
    }

    // Bank Account Management
    public function bankAccountsList(Request $request)
    {
        $seller = Auth::user();
        $bankAccounts = BankAccount::where('user_id', $seller->id)->get();
        return view('seller.bank-accounts.index', compact('bankAccounts'));
    }

    public function bankAccountsCreate()
    {
        return view('seller.bank-accounts.create');
    }

    public function bankAccountsStore(Request $request)
    {
        // Implementation for bank account creation
        return redirect()->route('seller.bank-accounts.index')->with('success', 'Bank account added successfully');
    }

    public function bankAccountsEdit($account)
    {
        return view('seller.bank-accounts.edit', compact('account'));
    }

    public function bankAccountsUpdate(Request $request, $account)
    {
        // Implementation for bank account update
        return redirect()->route('seller.bank-accounts.index')->with('success', 'Bank account updated successfully');
    }

    public function bankAccountsDestroy($account)
    {
        // Implementation for bank account deletion
        return redirect()->route('seller.bank-accounts.index')->with('success', 'Bank account deleted successfully');
    }

    // Shipping Method Setup
    public function shippingList(Request $request)
    {
        $shop = Auth::user()->shop;
        $shippingMethods = $shop ? $shop->shippingMethods()->get() : collect();
        return view('seller.shipping.index', compact('shippingMethods'));
    }

    public function shippingCreate()
    {
        return view('seller.shipping.create');
    }

    public function shippingStore(Request $request)
    {
        // Implementation for shipping method creation
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method created successfully');
    }

    public function shippingEdit($shipping)
    {
        return view('seller.shipping.edit', compact('shipping'));
    }

    public function shippingUpdate(Request $request, $shipping)
    {
        // Implementation for shipping method update
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method updated successfully');
    }

    public function shippingDestroy($shipping)
    {
        // Implementation for shipping method deletion
        return redirect()->route('seller.shipping.index')->with('success', 'Shipping method deleted successfully');
    }

    // Wallet & Withdraw Flow
    public function walletDashboard(Request $request)
    {
        $seller = Auth::user();
        $wallet = $seller->wallet ?? new Wallet();
        $recentTransactions = $wallet->transactions()->latest()->take(10)->get();
        
        return view('seller.wallet.index', compact('wallet', 'recentTransactions'));
    }

    public function walletTransactions(Request $request)
    {
        $seller = Auth::user();
        $transactions = $seller->wallet ? $seller->wallet->transactions()->paginate(20) : collect();
        return view('seller.wallet.transactions', compact('transactions'));
    }

    public function walletWithdrawForm()
    {
        $seller = Auth::user();
        $wallet = $seller->wallet;
        $bankAccounts = BankAccount::where('user_id', $seller->id)->get();
        
        return view('seller.wallet.withdraw.form', compact('wallet', 'bankAccounts'));
    }

    public function walletWithdrawRequest(Request $request)
    {
        // Implementation for withdraw request
        return redirect()->route('seller.wallet.index')->with('success', 'Withdraw request submitted successfully');
    }

    public function walletWithdrawHistory()
    {
        $seller = Auth::user();
        $withdrawHistory = $seller->withdrawRequests()->latest()->paginate(15);
        return view('seller.wallet.withdraw.history', compact('withdrawHistory'));
    }

    public function walletEarnings()
    {
        $seller = Auth::user();
        $earnings = $seller->earnings()->with('order')->latest()->paginate(15);
        return view('seller.wallet.earnings', compact('earnings'));
    }

    // Shop Settings
    public function shopSettings()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop.settings', compact('shop'));
    }

    public function shopSettingsUpdate(Request $request)
    {
        // Implementation for shop settings update
        return redirect()->route('seller.shop.settings')->with('success', 'Shop settings updated successfully');
    }

    // Orders Management
    public function ordersList(Request $request)
    {
        $shop = Auth::user()->shop;
        $orders = $shop ? $shop->orders()->with('user', 'items.product')->latest()->paginate(15) : collect();
        return view('seller.orders.index', compact('orders'));
    }

    public function ordersShow(Order $order)
    {
        return view('seller.orders.show', compact('order'));
    }

    public function ordersUpdateStatus(Request $request, Order $order)
    {
        // Implementation for order status update
        return redirect()->route('seller.orders.show', $order)->with('success', 'Order status updated successfully');
    }
}