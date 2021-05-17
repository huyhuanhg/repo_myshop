<?php


namespace app\core;


use Closure;
class BeforeMiddleware
{
    public $response, $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Perform action

        return $response;
    }

    public function redirect($request)
    {
        $this->response->redirect($request);
    }
}
