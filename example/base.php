<?php

require __DIR__ . '/../vendor/autoload.php';


// try {
//     (new Dotenv\Dotenv(__DIR__.'/../'))->load();
// } catch (Dotenv\Exception\InvalidPathException $e) {
//     //
// }


$app = new Laravel\Lumen\Application();

$app->get('/', function () use ($app) {
    // usleep(200000);
    return $app->version();
});

$app->loadComponent('swooleserver', [
        LumenSwooleHttp\LumenSwooleServiceProvide::class
    ], 'lumen.swoole')->createServer()->run();


