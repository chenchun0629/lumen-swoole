<?php 

namespace LumenSwooleHttp;


class LumenSwooleServerManager
{
    
    protected $app;

    protected $factory;

    protected $server;
    
    public function __construct($app, $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }


    public function createServer()
    {
        $this->server = $this->factory->make($this->app, config('swooleserver'));
        return $this->server;
    }

    public function run()
    {
        $this->server->run();
    }
}
