<?php

use Modules\AuthModule\Models\AdminUser;

return [

    'defaults' => [
        'guard' => 'web',  // Default guard is web, change as per requirement
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin_users',  // Custom admin user provider
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admin_users' => [
            'driver' => 'eloquent',
            'model' => App\Modules\AuthModule\Models\AdminUser\AdminUser::class,  // Ensure AdminUser model exists in Modules\AuthModule\Models
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admin_users' => [
            'provider' => 'admin_users',
            'table' => 'password_reset_tokens',  // Separate tokens for admins if needed
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800, // 3 hours timeout
];
