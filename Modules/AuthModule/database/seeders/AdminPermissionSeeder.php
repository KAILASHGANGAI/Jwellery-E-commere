<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AuthModule\Models\AdminPermission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'view_dashboard',
                'controller' => 'AdminController',
                'method' => 'index',
                'description' => 'Permission to view admin dashboard',
                'route' => '/myadmin',
                'status' => 1
            ],
            // ProductController permissions
            [
                'name' => 'view_products',
                'controller' => 'ProductController',
                'method' => 'index',
                'description' => 'Permission to view all products',
                'route' => '/products',
                'status' => 1
            ],
            [
                'name' => 'create_product',
                'controller' => 'ProductController',
                'method' => 'create',
                'description' => 'Permission to create a new product',
                'route' => '/products/create',
                'status' => 1
            ],
            [
                'name' => 'edit_product',
                'controller' => 'ProductController',
                'method' => 'edit',
                'description' => 'Permission to edit a product',
                'route' => '/products/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_product',
                'controller' => 'ProductController',
                'method' => 'destroy',
                'description' => 'Permission to delete a product',
                'route' => '/products/delete',
                'status' => 1
            ],

            // CollectionController permissions
            [
                'name' => 'view_collections',
                'controller' => 'CollectionController',
                'method' => 'index',
                'description' => 'Permission to view all collections',
                'route' => '/collections',
                'status' => 1
            ],
            [
                'name' => 'create_collection',
                'controller' => 'CollectionController',
                'method' => 'create',
                'description' => 'Permission to create a new collection',
                'route' => '/collections/create',
                'status' => 1
            ],
            [
                'name' => 'edit_collection',
                'controller' => 'CollectionController',
                'method' => 'edit',
                'description' => 'Permission to edit a collection',
                'route' => '/collections/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_collection',
                'controller' => 'CollectionController',
                'method' => 'destroy',
                'description' => 'Permission to delete a collection',
                'route' => '/collections/delete',
                'status' => 1
            ],

            // CustomerController permissions
            [
                'name' => 'view_customers',
                'controller' => 'CustomerController',
                'method' => 'index',
                'description' => 'Permission to view all customers',
                'route' => '/customers',
                'status' => 1
            ],
            [
                'name' => 'create_customer',
                'controller' => 'CustomerController',
                'method' => 'create',
                'description' => 'Permission to create a new customer',
                'route' => '/customers/create',
                'status' => 1
            ],
            [
                'name' => 'edit_customer',
                'controller' => 'CustomerController',
                'method' => 'edit',
                'description' => 'Permission to edit a customer',
                'route' => '/customers/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_customer',
                'controller' => 'CustomerController',
                'method' => 'destroy',
                'description' => 'Permission to delete a customer',
                'route' => '/customers/delete',
                'status' => 1
            ],

            // DeliveryLocationController permissions
            [
                'name' => 'view_delivery_locations',
                'controller' => 'DeliveryLocationController',
                'method' => 'index',
                'description' => 'Permission to view all delivery locations',
                'route' => '/delivery-locations',
                'status' => 1
            ],
            [
                'name' => 'create_delivery_location',
                'controller' => 'DeliveryLocationController',
                'method' => 'create',
                'description' => 'Permission to create a new delivery location',
                'route' => '/delivery-locations/create',
                'status' => 1
            ],
            [
                'name' => 'edit_delivery_location',
                'controller' => 'DeliveryLocationController',
                'method' => 'edit',
                'description' => 'Permission to edit a delivery location',
                'route' => '/delivery-locations/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_delivery_location',
                'controller' => 'DeliveryLocationController',
                'method' => 'destroy',
                'description' => 'Permission to delete a delivery location',
                'route' => '/delivery-locations/delete',
                'status' => 1
            ],

            // DiscountController permissions
            [
                'name' => 'view_discounts',
                'controller' => 'DiscountController',
                'method' => 'index',
                'description' => 'Permission to view all discounts',
                'route' => '/discounts',
                'status' => 1
            ],
            [
                'name' => 'create_discount',
                'controller' => 'DiscountController',
                'method' => 'create',
                'description' => 'Permission to create a new discount',
                'route' => '/discounts/create',
                'status' => 1
            ],
            [
                'name' => 'edit_discount',
                'controller' => 'DiscountController',
                'method' => 'edit',
                'description' => 'Permission to edit a discount',
                'route' => '/discounts/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_discount',
                'controller' => 'DiscountController',
                'method' => 'destroy',
                'description' => 'Permission to delete a discount',
                'route' => '/discounts/delete',
                'status' => 1
            ],

            // GiftCardController permissions
            [
                'name' => 'view_gift_cards',
                'controller' => 'GiftCardController',
                'method' => 'index',
                'description' => 'Permission to view all gift cards',
                'route' => '/gift-cards',
                'status' => 1
            ],
            [
                'name' => 'create_gift_card',
                'controller' => 'GiftCardController',
                'method' => 'create',
                'description' => 'Permission to create a new gift card',
                'route' => '/gift-cards/create',
                'status' => 1
            ],
            [
                'name' => 'edit_gift_card',
                'controller' => 'GiftCardController',
                'method' => 'edit',
                'description' => 'Permission to edit a gift card',
                'route' => '/gift-cards/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_gift_card',
                'controller' => 'GiftCardController',
                'method' => 'destroy',
                'description' => 'Permission to delete a gift card',
                'route' => '/gift-cards/delete',
                'status' => 1
            ],

            // OrderController permissions
            [
                'name' => 'view_orders',
                'controller' => 'OrderController',
                'method' => 'index',
                'description' => 'Permission to view all orders',
                'route' => '/orders',
                'status' => 1
            ],
            [
                'name' => 'create_order',
                'controller' => 'OrderController',
                'method' => 'create',
                'description' => 'Permission to create a new order',
                'route' => '/orders/create',
                'status' => 1
            ],
            [
                'name' => 'edit_order',
                'controller' => 'OrderController',
                'method' => 'edit',
                'description' => 'Permission to edit an order',
                'route' => '/orders/edit',
                'status' => 1
            ],
            [
                'name' => 'delete_order',
                'controller' => 'OrderController',
                'method' => 'destroy',
                'description' => 'Permission to delete an order',
                'route' => '/orders/delete',
                'status' => 1
            ],
        ];

        // Insert data into the permissions table
        foreach ($permissions as $permission) {
            AdminPermission::create($permission);
        }
    }
}
