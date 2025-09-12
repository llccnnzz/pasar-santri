<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckShopSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user has a shop and if it's suspended
        if ($user && $user->shop && $user->shop->isSuspended()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Your shop has been suspended.',
                    'reason' => $user->shop->suspended_reason,
                    'suspended_at' => $user->shop->suspended_at
                ], 403);
            }

            return redirect()->route('seller.dashboard')
                ->with('error', 'Your shop has been suspended. Reason: ' . $user->shop->suspended_reason);
        }

        return $next($request);
    }
}
