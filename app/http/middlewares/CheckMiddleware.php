<?php


namespace app\http\middlewares;


use app\core\BeforeMiddleware as Middleware;
use Closure;

class CheckMiddleware extends Middleware
{

    public function handle()
    {
        echo '<br/>' . __METHOD__ . '<br/>';
    }
}
