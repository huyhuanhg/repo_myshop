<?php


namespace app\http\middlewares;


use app\core\Cookie;
use app\core\Session;

class GlobalMiddleware
{
    public function handle()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey . '_user');
        if (!isset($user)) {
            $user = Cookie::data('user');
            if (isset($user) && !empty($user)) {
                Session::data($sessionKey . '_user', $user);
            }
        }
    }

    public function test()
    {
//        echo __METHOD__;
    }
}
