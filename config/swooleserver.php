<?php

return [

    'mode'           => 'http',
    
    'host'           => '0.0.0.0',
    'port'           => '9501',
    
    'swoole_setting' => [
        'worker_num'  => 2,                     // 同步模式worker number = php-fpm number
        'max_request' => 5000,
    ],

];
