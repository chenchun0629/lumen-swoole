<?php

return [

    'default' => env('SWOOLE_SERVER_MODE', 'http'),

    'servers' => [
        'http' => [
            'drive'   => 'http',
            'host'    => env('SWOOL_SERVER_HOST', '0.0.0.0'),
            'port'    => env('SWOOL_SERVER_PORT', '9501'),
            'setting' => [
                'worker_num'  => 2,                     // 同步模式worker number = php-fpm number
                'max_request' => 5000,
            ],
        ],

        /*
        
        'tcp' => [
            'drive'   => 'tpc',
            'host'    => env('SWOOL_SERVER_HOST', '0.0.0.0'),
            'port'    => env('SWOOL_SERVER_PORT', '9501'),
            'setting' => [
                // ...........
            ],
        ],

         */
    ],
];
