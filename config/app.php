<?php

/*
|--------------------------------------------------------------------------
| Application Config
|--------------------------------------------------------------------------
|
| This configuration file is for the Hyde Core, which is useful if you
| want to contribute to the source code. However, if you are looking
| to customize your static site, you are probably looking for the
| Hyde config located in `config/hyde.php`!
|
*/
return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => config('hyde.name', 'HydePHP'),

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | This value determines the "version" your application is currently running
    | in. You may want to follow the "Semantic Versioning" - Given a version
    | number MAJOR.MINOR.PATCH when an update happens: https://semver.org.
    |
    */

    'version' => app('git.version'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. This can be overridden using
    | the global command line "--env" option when calling commands.
    |
    | When using Hyde this setting should always be set to `production`.
    | However, when developing the Hyde Core, set it to `development`
    | in your .env to unlock the development commands.
    |
    */

    'env' => env('env', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [
        App\Providers\AppServiceProvider::class,
        Hyde\Framework\HydeServiceProvider::class,
    ],

    'aliases' => [
        'Hyde' => Hyde\Framework\Hyde::class,
    ],

];
