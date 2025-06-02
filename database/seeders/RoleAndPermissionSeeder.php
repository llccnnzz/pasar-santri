<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $map = [
            'customer' => [
                'homepage|wishlist',
                'homepage|add to cart',
                'homepage|checkout',
                'homepage|payment',

                'homepage|index order',
                'homepage|show order',
                'homepage|update order',
                'homepage|track order',
                'homepage|review order',

                'homepage|update account info',
            ],
            'seller' => [
                'seller-dashboard|index category',
                'seller-dashboard|create category',
                'seller-dashboard|update category',
                'seller-dashboard|delete category',

                'seller-dashboard|index product',
                'seller-dashboard|show product',
                'seller-dashboard|create product',
                'seller-dashboard|update product',
                'seller-dashboard|delete product',

                'seller-dashboard|index order',
                'seller-dashboard|show order',
                'seller-dashboard|update order',

                'seller-dashboard|show balance',
                'seller-dashboard|update balance',

                'seller-dashboard|index shipping method',
                'seller-dashboard|update shipping method',

                'seller-dashboard|index promo',
                'seller-dashboard|create promo',
                'seller-dashboard|update promo',
                'seller-dashboard|delete promo',

                'seller-dashboard|update account info',

            ],
            'admin' => [
                'admin-dashboard|index seller',
                'admin-dashboard|show seller',
                'admin-dashboard|update seller',

                'admin-dashboard|index product',
                'admin-dashboard|show product',
                'admin-dashboard|update product',

                'admin-dashboard|index order',
                'admin-dashboard|show order',
                'admin-dashboard|update order',

                'admin-dashboard|index shipping method',
                'admin-dashboard|show shipping method',
                'admin-dashboard|create shipping method',
                'admin-dashboard|update shipping method',
                'admin-dashboard|delete shipping method',

                'admin-dashboard|index banner',
                'admin-dashboard|show banner',
                'admin-dashboard|create banner',
                'admin-dashboard|update banner',
                'admin-dashboard|delete banner',

                'admin-dashboard|index ads',
                'admin-dashboard|show ads',
                'admin-dashboard|create ads',
                'admin-dashboard|update ads',
                'admin-dashboard|delete ads',
            ]
        ];

        foreach ($map as $role => $permissions) {
            $r = Role::create(['name' => $role]);
            foreach ($permissions as $permission) {
                $p = Permission::create(['name' => $permission]);
                $r->givePermissionTo($p);
            }
        }
    }
}
