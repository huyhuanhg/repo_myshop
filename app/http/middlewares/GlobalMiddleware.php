<?php


namespace app\http\middlewares;


use app\core\Cookie;
use app\core\Response;
use app\core\Session;
use Closure;


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


        //handler params
//        list($path, $gets) = explode('?', $_SERVER['REQUEST_URI']);
//        if (!empty($gets)) {
//            $getArr = explode('&', $gets);
//            foreach ($getArr as $p => $get) {
//                $i = strpos($get, '=');
//                if (!$i) {
//                    unset($getArr[$p]);
//                } else{
//                    if ($i === 0 || $i=== strlen($get)-1){
//                        unset($getArr[$p]);
//                    }
//                }
//            }
//        }
//        $gets = implode('&',$getArr);
//        $uri = "$path?$gets";
//        $this.$this->handler($uri, function ($url){
//            $r = new Response();
////            $r->redirect(__WEB_ROOT__);
//        });
    }

    private function handler($request, Closure $next)
    {
        $response = $next($request);

        // Perform action

        return $response;
    }
}
