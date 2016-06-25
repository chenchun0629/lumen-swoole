<?php

require __DIR__ . '/../vendor/autoload.php';


// try {
//     (new Dotenv\Dotenv(__DIR__.'/../'))->load();
// } catch (Dotenv\Exception\InvalidPathException $e) {
//     //
// }


$app = new Laravel\Lumen\Application();

$app->get('/', function () use ($app) {
    return $app->version();
});

$server = new LumenSwooleHttp\Server($app);
$server->run();

