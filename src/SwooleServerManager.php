<?php 

namespace LumenSwoole;

use InvalidArgumentException;
use Illuminate\Support\Arr;

class SwooleServerManager
{
    
    protected $app;

    protected $factory;

    protected $server;
    
    public function __construct($app, $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }


    public function server($name = null)
    {
        if (empty($this->server)) {
            $name = $name ?: $this->getDefaultServer();

            $this->server = $this->makeServer($name);
        }

        return $this->server;
    }

    public function run()
    {
        $this->server->run();
    }

    /**
     * 创建服务
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    protected function makeServer($name)
    {
        $config = $this->getConfig($name);

        return $this->factory->make($config, $name);
    }

    /**
     * 获取配置
     * @return [type] [description]
     */
    protected function getConfig($name = null)
    {
        $name = $name ?: $this->getDefaultServer();

        $servers = $this->app['config']['swooleserver.servers'];

        if (is_null($config = Arr::get($servers, $name))) {
            throw new InvalidArgumentException("Server [$name] not configured.");
        }

        return $config;
    }

    /**
     * 获取默认服务
     * @return [type] [description]
     */
    protected function getDefaultServer()
    {
        return $this->app['config']['swooleserver.default'];
    }
}
