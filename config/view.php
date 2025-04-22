<?php

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

    /*
    |--------------------------------------------------------------------------
    | View Blade Compiler Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify Blade compiler options that should be used when
    | processing your templates. You can enable or disable debugging and
    | specify the default extension for your Blade template files.
    |
    */
    'blade' => [
        'debug' => env('APP_DEBUG', false),
        'default_extension' => 'blade.php',
        'cache' => [
            'path' => storage_path('framework/views'),
            'expire' => 60,
        ],
    ],
]; 