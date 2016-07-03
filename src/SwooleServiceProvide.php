<?php 

namespace LumenSwoole;

use Illuminate\Support\ServiceProvider;

use LumenSwoole\Contracts\ServerContract;

class SwooleServiceProvide extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('lumen.swoole.factory', function($app) {
            return new SwooleFactory($app);
        });

        $this->app->singleton('lumen.swoole', function ($app) {
            return new SwooleServerManager($app, app('lumen.swoole.factory'));
        });
    }
}
