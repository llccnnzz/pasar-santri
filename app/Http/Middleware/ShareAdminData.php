<?php

namespace App\Http\Middleware;

use App\Models\KycApplication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareAdminData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only share data for admin routes
        if ($request->routeIs('admin.*')) {
            $pendingKycCount = KycApplication::where('status', 'pending')->count();

            View::share('pendingKycCount', $pendingKycCount);
        }

        return $next($request);
    }
}
