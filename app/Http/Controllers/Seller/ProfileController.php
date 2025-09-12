<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display profile overview
     */
    public function index()
    {
        $user = auth()->user();
        return view('seller.profile.index', compact('user'));
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $user = auth()->user();
        return view('seller.profile.edit', compact('user'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('seller.profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show security settings
     */
    public function security()
    {
        $user = auth()->user();
        return view('seller.profile.security', compact('user'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Show withdrawal PIN setup/management
     */
    public function withdrawalPin()
    {
        $user = auth()->user();
        return view('seller.profile.withdrawal-pin', compact('user'));
    }

    /**
     * Setup or update withdrawal PIN
     */
    public function updateWithdrawalPin(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'pin' => 'required|digits:6|confirmed',
        ];

        // If user already has a PIN, require current PIN
        if ($user->hasWithdrawalPin()) {
            $rules['current_pin'] = 'required|digits:6';
        }

        $request->validate($rules);

        // Verify current PIN if user has one
        if ($user->hasWithdrawalPin()) {
            if (!$user->verifyWithdrawalPin($request->current_pin)) {
                return back()->withErrors(['current_pin' => 'Current PIN is incorrect.']);
            }
        }

        try {
            $user->setWithdrawalPin($request->pin);

            $message = $user->hasWithdrawalPin() ? 'Withdrawal PIN updated successfully!' : 'Withdrawal PIN set successfully!';
            return back()->with('success', $message);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['pin' => $e->getMessage()]);
        }
    }

    /**
     * Verify withdrawal PIN (for sensitive operations)
     */
    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:6',
        ]);

        $user = auth()->user();

        if (!$user->hasWithdrawalPin()) {
            return response()->json(['success' => false, 'message' => 'Withdrawal PIN not set.']);
        }

        if ($user->verifyWithdrawalPin($request->pin)) {
            $user->markPinAsVerified();
            return response()->json(['success' => true, 'message' => 'PIN verified successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid PIN.']);
    }
}
