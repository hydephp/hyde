<?php

return [
    'paths' => [
        resource_path('views'),
        base_path('_pages'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
