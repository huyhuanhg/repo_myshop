<?php
namespace app\http\middlewares;
use app\core\BeforeMiddleware as Middleware;
use app\core\Session;

class Authenticate extends Middleware
{
    public function handle()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey.'_user');
        if (!isset($user)) {
            parent::handle('/',function ($request){
                $this->redirect($request);
            });
        }
    }
    public function logined()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey . '_user');
        if (isset($user)) {
            parent::handle('/person', function ($request) {
                $this->redirect($request);
            });
        }
    }
}
