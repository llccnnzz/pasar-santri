<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserAddressStoreRequest;
use App\Http\Requests\UserAddressUpdateRequest;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user      = auth()->user();
        $addresses = $user->addresses ?? [];

        return view('user.addresses.index', compact('addresses'));
    }

    public function store(UserAddressStoreRequest $request)
    {
        $user = auth()->user();

        $addressData = $request->only([
            'label', 'name', 'phone', 'address_line_1', 'address_line_2',
            'province', 'city', 'subdistrict', 'village', 'postal_code', 'country',
        ]);

        $addressData['is_primary'] = $request->boolean('is_primary');

        // If this is the first address, make it primary
        if (! $user->addresses || empty($user->addresses)) {
            $addressData['is_primary'] = true;
        }

        $user->addAddress($addressData);

        return redirect('/me?page=address')->with('success', 'Address added successfully!');
    }

    public function update(UserAddressUpdateRequest $request, string $addressId)
    {
        $user = auth()->user();

        $addressData = $request->only([
            'label', 'name', 'phone', 'address_line_1', 'address_line_2',
            'province', 'city', 'subdistrict', 'village', 'postal_code', 'country',
        ]);

        $addressData['is_primary'] = $request->boolean('is_primary');

        $user->updateAddress($addressId, $addressData);

        return redirect('/me?page=address')->with('success', 'Address updated successfully!');
    }

    public function destroy(string $addressId)
    {
        $user = auth()->user();
        $user->removeAddress($addressId);

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully!',
        ]);
    }

    public function setPrimary(Request $request)
    {
        $user      = auth()->user();
        $addressId = $request->input('address_id');

        if (! $addressId) {
            return response()->json(['error' => 'Address ID is required'], 400);
        }

        // Find the address and set it as primary
        $addresses = $user->addresses ?? [];
        $found     = false;

        foreach ($addresses as &$address) {
            if ($address['id'] === $addressId) {
                $address['is_primary'] = true;
                $found                 = true;
            } else {
                $address['is_primary'] = false;
            }
        }

        if (! $found) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $user->addresses = $addresses;
        $user->save();

        return response()->json([
            'success'         => true,
            'message'         => 'Primary address updated successfully!',
            'primary_address' => $user->primary_address,
        ]);
    }

    public function getAddresses()
    {
        $user      = auth()->user();
        $addresses = $user->addresses ?? [];

        return response()->json([
            'addresses'       => $addresses,
            'primary_address' => $user->primary_address,
        ]);
    }
}
