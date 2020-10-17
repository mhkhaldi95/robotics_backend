<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'students',
        'passwords' => 'students',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'owners' => [
            'driver' => 'jwt',
            'provider' => 'owners',
            'hash' => false,
        ],
        'admins' => [
            'driver' => 'jwt',
            'provider' => 'admins',
            'hash' => false,
        ],
        'fathers' => [
            'driver' => 'jwt',
            'provider' => 'fathers',
            'hash' => false,
        ],
        'trainers' => [
            'driver' => 'jwt',
            'provider' => 'trainers',
            'hash' => false,
        ],
        'students' => [
            'driver' => 'jwt',
            'provider' => 'students',
            'hash' => false,
        ],
        'sellers' => [
            'driver' => 'jwt',
            'provider' => 'sellers',
            'hash' => false,
        ],
        'organizers' => [
            'driver' => 'jwt',
            'provider' => 'organizers',
            'hash' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'owners' => [
            'driver' => 'eloquent',
            'model' => App\Owner::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],
        'fathers' => [
            'driver' => 'eloquent',
            'model' => App\Father::class,
        ],
        'trainers' => [
            'driver' => 'eloquent',
            'model' => App\Trainer::class,
        ],
        'organizers' => [
            'driver' => 'eloquent',
            'model' => App\Organizer::class,
        ],
        'sellers' => [
            'driver' => 'eloquent',
            'model' => App\Seller::class,
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Student::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'owners' => [
            'provider' => 'owners',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'fathers' => [
            'provider' => 'fathers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'trainers' => [
            'provider' => 'trainers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'organizers' => [
            'provider' => 'organizers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'sellers' => [
            'provider' => 'sellers',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'students' => [
            'provider' => 'students',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
