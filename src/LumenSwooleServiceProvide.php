<?php 

namespace LumenSwooleHttp;

use Illuminate\Support\ServiceProvider;

use LumenSwooleHttp\Contracts\ServerContract;

class LumenSwooleServiceProvide extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('lumen.swoole.factory', LumenSwooleFactory::class);

        $this->app->singleton('lumen.swoole', function ($app) {
            return new LumenSwooleServerManager($app, app('lumen.swoole.factory'));
        });
    }
}
