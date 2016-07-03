<?php 

namespace LumenSwoole;


use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;

class SwooleFactory
{

    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Create a new connection factory instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function make(array $config, $name)
    {
        $config = $this->parseConfig($config, $name);
        return $this->createServer($config['drive'], $config);
    }

    protected function parseConfig(array $config, $name)
    {
        return Arr::add($config, 'name', $name);
    }

    protected function createServer($driver, array $config)
    {
        // if ($this->container->bound($key = "swoole.server.{$driver}")) {
        //     return $this->container->make($key, [$this->container, $config['host'], $config['port'], $config['setting']]);
        // }

        switch ($driver) {
            case 'http':
                return new HttpServer($this->container, $config['host'], $config['port'], $config['setting']);
        }

        throw new InvalidArgumentException("Unsupported driver [$driver]");
    }

}
