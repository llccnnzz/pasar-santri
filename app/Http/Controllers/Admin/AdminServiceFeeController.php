<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminServiceFeeController extends Controller
{
    /**
     * Display the service fees management page
     */
    public function index()
    {
        // Get all payment fee related variables
        $paymentFees = [
            'payment_fee_type' => [
                'label' => 'Fee Type',
                'description' => 'Type of payment fee calculation (percent or fixed)',
                'type' => 'select',
                'options' => [
                    'percent' => 'Percentage',
                    'fixed' => 'Fixed Amount'
                ],
                'value' => GlobalVariable::getValue('payment_fee_type', 'percent'),
                'key' => 'payment_fee_type'
            ],
            'payment_fee_percent' => [
                'label' => 'Fee Percentage',
                'description' => 'Percentage fee to charge (when fee type is percent)',
                'type' => 'number',
                'step' => '0.01',
                'min' => '0',
                'max' => '100',
                'suffix' => '%',
                'value' => GlobalVariable::getValue('payment_fee_percent', 2),
                'key' => 'payment_fee_percent'
            ],
            'payment_fee_percent_min_value' => [
                'label' => 'Minimum Fee Amount',
                'description' => 'Minimum fee amount when using percentage (in IDR)',
                'type' => 'number',
                'step' => '100',
                'min' => '0',
                'prefix' => 'IDR',
                'value' => GlobalVariable::getValue('payment_fee_percent_min_value', 2000),
                'key' => 'payment_fee_percent_min_value'
            ],
            'payment_fee_percent_max_value' => [
                'label' => 'Maximum Fee Amount',
                'description' => 'Maximum fee amount when using percentage (in IDR). Leave empty for no limit.',
                'type' => 'number',
                'step' => '100',
                'min' => '0',
                'prefix' => 'IDR',
                'value' => GlobalVariable::getValue('payment_fee_percent_max_value'),
                'key' => 'payment_fee_percent_max_value'
            ],
            'payment_fee_fixed' => [
                'label' => 'Fixed Fee Amount',
                'description' => 'Fixed fee amount to charge (when fee type is fixed)',
                'type' => 'number',
                'step' => '100',
                'min' => '0',
                'prefix' => 'IDR',
                'value' => GlobalVariable::getValue('payment_fee_fixed', 2500),
                'key' => 'payment_fee_fixed'
            ]
        ];

        return view('admin.service-fees.index', compact('paymentFees'));
    }

    /**
     * Update a service fee setting
     */
    public function update(Request $request, string $serviceFee)
    {
        // Validate that the key is a payment fee key
        if (!str_starts_with($serviceFee, 'payment_fee')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid service fee key.'
            ], 400);
        }

        // Validation rules based on the fee type
        $rules = match($serviceFee) {
            'payment_fee_type' => [
                'value' => 'required|in:percent,fixed'
            ],
            'payment_fee_percent' => [
                'value' => 'required|numeric|min:0|max:100'
            ],
            'payment_fee_percent_min_value' => [
                'value' => 'nullable|numeric|min:0'
            ],
            'payment_fee_percent_max_value' => [
                'value' => 'nullable|numeric|min:0'
            ],
            'payment_fee_fixed' => [
                'value' => 'required|numeric|min:0'
            ],
            default => [
                'value' => 'required'
            ]
        };

        $request->validate($rules);

        try {
            DB::transaction(function () use ($serviceFee, $request) {
                // Get the appropriate type for the variable
                $type = match($serviceFee) {
                    'payment_fee_type' => 'string',
                    'payment_fee_percent',
                    'payment_fee_percent_min_value',
                    'payment_fee_percent_max_value',
                    'payment_fee_fixed' => 'float',
                    default => 'string'
                };

                // Handle nullable values
                $value = $request->value;
                if ($value === '' || $value === null) {
                    if (in_array($serviceFee, ['payment_fee_percent_max_value'])) {
                        $value = null;
                    }
                }

                GlobalVariable::setValue($serviceFee, $value, $type);
            });

            return response()->json([
                'success' => true,
                'message' => 'Service fee updated successfully.',
                'data' => [
                    'key' => $serviceFee,
                    'value' => $request->value
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service fee: ' . $e->getMessage()
            ], 500);
        }
    }
}
