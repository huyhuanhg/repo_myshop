<?php

namespace app\http\middlewares;

use app\core\BeforeMiddleware as Middleware;
use app\core\Cookie;
use app\core\Session;
use app\Exceptions\AppException;

class Authenticate extends Middleware
{
    public function handle()
    {
        $sessionKey = Session::isInvalid();
        $user = json_decode(Session::data($sessionKey . '_user'));
        if (!isset($user) || $user->level == 0) {
            parent::handle('/', function ($request) {
                $this->redirect($request);
            });
        }
    }

    public function logined()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey . '_user');
        if (isset($user) && !empty($user)) {
            parent::handle('/', function ($request) {
                $this->redirect($request);
            });
        }
    }

    public function ajax()
    {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            AppException::loadError();
        }
    }
}
