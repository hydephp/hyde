<?php

return [
    'paths' => [
        Hyde\Core\Hyde::viewPath(),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),
];
