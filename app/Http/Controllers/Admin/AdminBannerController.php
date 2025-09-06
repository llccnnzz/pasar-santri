<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    /**
     * Display the banner promotion management page
     */
    public function index()
    {
        // Get all banner promotion related variables
        $bannerPromotions = [
            'banner_promotion_headline_primary' => [
                'label' => 'Headline Primary Banners',
                'description' => 'Main carousel banners on homepage (supports multiple images)',
                'type' => 'json',
                'is_multiple' => true,
                'value' => GlobalVariable::getValue('banner_promotion_headline_primary', []),
                'key' => 'banner_promotion_headline_primary'
            ],
            'banner_promotion_headline_secondary' => [
                'label' => 'Headline Secondary Banner',
                'description' => 'Secondary banner next to main carousel',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_headline_secondary', ''),
                'key' => 'banner_promotion_headline_secondary'
            ],
            'banner_promotion_headline_child_1' => [
                'label' => 'Headline Child Banner 1',
                'description' => 'First child banner in the headline section',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_headline_child_1', ''),
                'key' => 'banner_promotion_headline_child_1'
            ],
            'banner_promotion_headline_child_2' => [
                'label' => 'Headline Child Banner 2',
                'description' => 'Second child banner in the headline section',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_headline_child_2', ''),
                'key' => 'banner_promotion_headline_child_2'
            ],
            'banner_promotion_headline_child_3' => [
                'label' => 'Headline Child Banner 3',
                'description' => 'Third child banner in the headline section',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_headline_child_3', ''),
                'key' => 'banner_promotion_headline_child_3'
            ],
            'banner_promotion_daily_best_seller' => [
                'label' => 'Daily Best Seller Banner',
                'description' => 'Banner for daily best seller section',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_daily_best_seller', ''),
                'key' => 'banner_promotion_daily_best_seller'
            ],
            'banner_promotion_footline' => [
                'label' => 'Footer Banner',
                'description' => 'Banner displayed in the footer area',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_footline', ''),
                'key' => 'banner_promotion_footline'
            ],
            'banner_promotion_login' => [
                'label' => 'Login Page Banner',
                'description' => 'Banner displayed on the login page',
                'type' => 'string',
                'is_multiple' => false,
                'value' => GlobalVariable::getValue('banner_promotion_login', ''),
                'key' => 'banner_promotion_login'
            ]
        ];

        return view('admin.banners.index', compact('bannerPromotions'));
    }

    /**
     * Update a banner promotion setting
     */
    public function update(Request $request, string $banner)
    {
        // Validate that the key is a banner promotion key
        if (!str_starts_with($banner, 'banner_promotion')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid banner promotion key.'
            ], 400);
        }

        // Get banner configuration
        $bannerConfig = $this->getBannerConfig($banner);
        if (!$bannerConfig) {
            return response()->json([
                'success' => false,
                'message' => 'Banner configuration not found.'
            ], 400);
        }

        // Validation rules
        $rules = [];
        if ($bannerConfig['is_multiple']) {
            $rules['images'] = 'required|array|min:1|max:10';
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        } else {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        $request->validate($rules);

        try {
            DB::transaction(function () use ($banner, $request, $bannerConfig) {
                $uploadedPaths = [];

                if ($bannerConfig['is_multiple']) {
                    // Handle multiple images
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('banners', 'public');
                        $uploadedPaths[] = '/storage/' . $path;
                    }

                    // Store as JSON array
                    GlobalVariable::setValue($banner, $uploadedPaths, 'json');
                } else {
                    // Handle single image
                    $image = $request->file('image');
                    $path = $image->store('banners', 'public');
                    $uploadedPath = '/storage/' . $path;

                    // Store as string
                    GlobalVariable::setValue($banner, $uploadedPath, 'string');
                    $uploadedPaths[] = $uploadedPath;
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Banner promotion updated successfully.',
                'data' => [
                    'key' => $banner,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update banner promotion: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get banner configuration
     */
    private function getBannerConfig(string $key): ?array
    {
        $configs = [
            'banner_promotion_headline_primary' => [
                'is_multiple' => true,
                'type' => 'json'
            ],
            'banner_promotion_headline_secondary' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_headline_child_1' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_headline_child_2' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_headline_child_3' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_daily_best_seller' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_footline' => [
                'is_multiple' => false,
                'type' => 'string'
            ],
            'banner_promotion_login' => [
                'is_multiple' => false,
                'type' => 'string'
            ]
        ];

        return $configs[$key] ?? null;
    }
}
