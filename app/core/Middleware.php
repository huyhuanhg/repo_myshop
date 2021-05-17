<?php


namespace app\core;


//class viet function dang ki middleware va ham goi class thuc thi middleware rieng
use app\Exceptions\AppException as E;

class Middleware
{
    private $route;
    private static $registry;

    public function __construct($route)
    {
        $this->route = $route !== '/' ? trim($route, '/') : '/';
    }

    public function middleware($middlware)
    {
        self::$registry[$this->route] = $middlware;
    }

    private static function runGlobalMiddleWare()
    {
        $app = Registry::getIntance()->app;
        if (isset($app) && array_key_exists('globalMiddleware', $app)) {
            $middlewareType = $app['globalMiddleware'];
            if (is_array($middlewareType)) {
                foreach ($middlewareType as $middlewareItem) {
                    self::callHandleMiddleware($middlewareItem);
                }
            } elseif (is_string($middlewareType)) {
                self::callHandleMiddleware($middlewareType);
            }
        }
    }

    public static function runBeforeMiddleware()
    {
        self::runGlobalMiddleWare();
        $requestURI = Router::getRequestURL();
        $app = Registry::getIntance()->app;
        if (isset($app) && array_key_exists('routeMiddlware', $app)
            && array_key_exists($requestURI, self::$registry)) {
            $middlewareType = self::$registry[$requestURI];
            if (is_array($middlewareType)) {
                foreach ($middlewareType as $middlewareItem) {
                    self::checkMiddleware($middlewareItem);
                }
            } elseif (is_string($middlewareType)) {
                self::checkMiddleware($middlewareType);
            }
        }
    }

    private static function checkMiddleware($middleware)
    {
        $routerMiddleware = Registry::getIntance()->app['routeMiddlware'];
        if (array_key_exists($middleware, $routerMiddleware)) {
            $beforeMiddleware = $routerMiddleware[$middleware];
            self::callHandleMiddleware($beforeMiddleware);
        } else {
            self::callHandleMiddleware($middleware);
        }
    }

    private static function callHandleMiddleware($call_function)
    {
        if (is_array($call_function)) {
            $className = reset($call_function);
            $method = end($call_function);
        } elseif (is_string($call_function)) {
            $className = $call_function;
            $method = 'handle';
        }
        $middlewareFile = __DIR_ROOT__ . '/' . str_replace('\\', '/', $className) . ".php";
        if (file_exists($middlewareFile)) {
            if (class_exists($className) && method_exists($className, $method)) {
                $middlewareObj = new $className;
//                Registry::getIntance()->$className = $middlewareObj;
                call_user_func_array([$middlewareObj, $method], []);
            } else {
                throw new E("$className hoặc $method() không tồn tại!");
//                    echo "loi class hoac method";
            }
        } else {
            E::loadError('404');
        }
    }
}

