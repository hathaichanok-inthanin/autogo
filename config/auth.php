<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],

        'admin-api' => [
            'driver' => 'token',
            'provider' => 'admin',
            'hash' => false,
        ],

        'member' => [
            'driver' => 'session',
            'provider' => 'members',
        ],

        'member-api' => [
            'driver' => 'token',
            'provider' => 'members',
            'hash' => false,
        ],

        'staff' => [
            'driver' => 'session',
            'provider' => 'staffs',
        ],

        'staff-api' => [
            'driver' => 'token',
            'provider' => 'staffs',
            'hash' => false,
        ],
    ],


    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        'members' => [
            'driver' => 'eloquent',
            'model' => App\Models\Member::class,
        ],

        'staffs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Staff::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admin' => [
            'provider' => 'admin',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'member' => [
            'provider' => 'members',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'staff' => [
            'provider' => 'staffs',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
