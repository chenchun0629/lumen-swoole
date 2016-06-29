<?php 

namespace LumenSwooleHttp;


class LumenSwooleFactory
{

    public function make($app, array $config)
    {
        if ($config['mode'] != 'http') {
            throw new \Exception("error swoole server mode");
        }

        return new HttpServer($app, $config['host'], $config['port'], $config['swoole_setting']);
    }

}
