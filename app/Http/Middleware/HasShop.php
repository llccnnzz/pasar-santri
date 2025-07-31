<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasShop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = $request->user();
        $currentUser->load('shop');

        if (!$currentUser['shop']) {
            return redirect()->route('seller.shop.setup')->with('error', 'Please setup your shop first.');
        }
        return $next($request);
    }
}
