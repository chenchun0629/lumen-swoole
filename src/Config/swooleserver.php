<?php

return [

    'mode'           => 'http',
    
    'host'           => '0.0.0.0',
    'prot'           => '9501',
    
    'swoole_setting' => [
        'worker_num'  => 1,                     // 同步模式worker number = php-fpm number
        'max_request' => 5000,
    ],

];
