<?php 

namespace LumenSwooleHttp;

use swoole_http_server as SwooleHttpServer;
use swoole_http_request as SwooleHttpRequest;
use swoole_http_response as SwooleHttpResponse;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Http\Request as LumenRequest;

class Server
{
    protected $app = null;

    public function __construct(LumenApplication $app)
    {
        $this->app = $app;
    }

    public function run()
    {
        $http = new SwooleHttpServer("0.0.0.0", 9501);
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

            $clone = clone $this->app;
            $clone::setInstance($clone);

            $get     = isset($request->get) ? $request->get : [];
            $post    = isset($request->post) ? $request->post : [];
            $cookie  = isset($request->cookie) ? $request->cookie : [];
            $server  = isset($request->server) ? $request->server : [];
            $header  = isset($request->header) ? $request->header : [];
            $files   = isset($request->files) ? $request->files : [];
            $content = $request->rawContent() ?: null;

            $lumenRequest = LumenRequest::create($server['request_uri'], $server['request_method'], array_merge($get, $post), $cookie, $files, $server, $content);
            $response->end($this->app->dispatch($lumenRequest)->content());
            
            $clone->flush();
            unset($clone);
        };
    }

}
