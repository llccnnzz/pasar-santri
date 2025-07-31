<?php

namespace App\Http\Middleware;

use App\Models\KycApplication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasApprovedKyc
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user has approved KYC
        $approvedKyc = KycApplication::where('user_id', $user->id)
            ->where('status', 'approved')
            ->exists();
            
        if (!$approvedKyc) {
            return redirect()->route('kyc.index')
                ->with('error', 'You must complete and get your KYC verification approved before proceeding.');
        }
        
        return $next($request);
    }
}
