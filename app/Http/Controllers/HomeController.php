<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $currentUser = $request->user();
        return view('buyer.account', compact('currentUser'));
    }

    public function account(Request $request)
    {
        $currentUser = $request->user();
        $addresses = $currentUser->addresses ?? [];
        return view('buyer.account', compact('currentUser', 'addresses'));
    }
}
