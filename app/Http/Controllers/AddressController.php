<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's addresses
     */
    public function index()
    {
        $user = auth()->user();
        $addresses = $user->addresses ?? [];
        
        return view('user.addresses.index', compact('addresses'));
    }

    /**
     * Store a new address
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_primary' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        
        $addressData = $request->only([
            'label', 'name', 'phone', 'address_line_1', 'address_line_2',
            'city', 'state', 'postal_code', 'country'
        ]);
        
        $addressData['is_primary'] = $request->boolean('is_primary');
        
        // If this is the first address, make it primary
        if (!$user->addresses || empty($user->addresses)) {
            $addressData['is_primary'] = true;
        }

        $user->addAddress($addressData);

        return redirect()->back()->with('success', 'Address added successfully!');
    }

    /**
     * Update an address
     */
    public function update(Request $request, string $addressId)
    {
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_primary' => 'boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        
        $addressData = $request->only([
            'label', 'name', 'phone', 'address_line_1', 'address_line_2',
            'city', 'state', 'postal_code', 'country'
        ]);
        
        $addressData['is_primary'] = $request->boolean('is_primary');

        $user->updateAddress($addressId, $addressData);

        return redirect()->back()->with('success', 'Address updated successfully!');
    }

    /**
     * Delete an address
     */
    public function destroy(string $addressId)
    {
        $user = auth()->user();
        $user->removeAddress($addressId);

        return redirect()->back()->with('success', 'Address deleted successfully!');
    }

    /**
     * Set primary address via AJAX
     */
    public function setPrimary(Request $request)
    {
        $user = auth()->user();
        $addressId = $request->input('address_id');
        
        if (!$addressId) {
            return response()->json(['error' => 'Address ID is required'], 400);
        }

        // Find the address and set it as primary
        $addresses = $user->addresses ?? [];
        $found = false;
        
        foreach ($addresses as &$address) {
            if ($address['id'] === $addressId) {
                $address['is_primary'] = true;
                $found = true;
            } else {
                $address['is_primary'] = false;
            }
        }
        
        if (!$found) {
            return response()->json(['error' => 'Address not found'], 404);
        }
        
        $user->addresses = $addresses;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Primary address updated successfully!',
            'primary_address' => $user->primary_address
        ]);
    }

    /**
     * Get addresses for location dropdown (AJAX)
     */
    public function getAddresses()
    {
        $user = auth()->user();
        $addresses = $user->addresses ?? [];
        
        return response()->json([
            'addresses' => $addresses,
            'primary_address' => $user->primary_address
        ]);
    }
}
