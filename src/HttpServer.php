<?php 

namespace LumenSwoole;


use swoole_http_server as SwooleHttpServer;
use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;

use LumenSwoole\Contracts\ServerContract;
use Illuminate\Http\Request as LumenRequest;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Database\Eloquent\Model;

class HttpServer implements ServerContract
{
    protected $app = null;
    protected $host;
    protected $port;
    protected $setting;

    public function __construct(LumenApplication $app, $host, $port, $setting)
    {
        $this->app     = $app;
        $this->host    = $host;
        $this->port    = $port;
        $this->setting = $setting;
    }
    
    public function run()
    {
        $http = new SwooleHttpServer($this->host, $this->port);
        $http->set($this->setting);
        $http->on('start', $this->_onStart());
        $http->on('shutdown', $this->_onShutdown());
        $http->on('WorkerStart', $this->_onWorkerStart());
        $http->on('request', $this->_onRequest());
        $http->start();
    }

    protected function _onStart()
    {
        return function($swooleHttpServer) {
            echo "http server start ......\n";
        };
    }

    protected function _onShutdown()
    {
        return function($swooleHttpServer) {
            echo "http server shutdown ...... \n";
        };
    }

    protected function _onWorkerStart()
    {
        return function($swooleHttpServer, $workerId) {
            echo "http worker start ..... \n";
        };
    }

    protected function _onWorkerStop()
    {
        return function($swooleHttpServer, $workerId) {
            echo "http worker stop ..... \n";
        };
    }

    protected function _onWorkerError($swooleHttpServer, $workerId, $workerPid, $exitCode)
    {
        return function($swooleHttpServer, $workerId, $workerPid, $exitCode) {
            echo "http worker error ..... \n";
        };
    }

    protected function _onRequest()
    {
        return function (SwooleHttpRequest $request, SwooleHttpResponse $response) {

            $app = $this->_initApplication();

            $lumenRequest = $this->_createLumenRequest($request);
            $response->end($app->dispatch($lumenRequest)->getContent());
            
            $this->_destoryApplication($app);
        };
    }

    protected function _createLumenRequest(SwooleHttpRequest $request)
    {
        $get     = isset($request->get) ? $request->get : [];
        $post    = isset($request->post) ? $request->post : [];
        $cookie  = isset($request->cookie) ? $request->cookie : [];
        $server  = isset($request->server) ? $request->server : [];
        $header  = isset($request->header) ? $request->header : [];
        $files   = isset($request->files) ? $request->files : [];
        $content = $request->rawContent() ?: null;

        return LumenRequest::create($server['request_uri'], $server['request_method'], array_merge($get, $post), $cookie, $files, $server, $content);
    }

    protected function _initApplication()
    {
        if ($this->app['db']) {
            Model::clearBootedModels();
        }

        $clone = clone $this->app;
        $clone::setInstance($clone);

        return $clone;
    }

    protected function _destoryApplication($app)
    {
        $app->flush();
        unset($app);
    }
}
