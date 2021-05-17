<?php

namespace app\core;

use app\Exceptions\AppException  as E;

/**
 * Class Router
 */
class Router
{
    private static $group = [];
    private static $namespace;
    private static $routers = [];


    public function __construct()
    {
    }

    public static function getRequestURL()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = trim($_SERVER['PATH_INFO'], '/');
        }
//        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
//        $url = str_replace($this->basePath, '', $url);
        return $url ?? '/';
    }

    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
    public static function view($view, $data = null){
        $viewPath = __DIR_ROOT__ . '/app/' . $view . '.php';
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $data;
        }
        if (file_exists($viewPath)) {
            require_once($viewPath);
        }
        die();
    }
    private static function addRouter($method, $url, $action)
    {

        $namespace = self::findNamespace();
        self::$routers[] = [$method, $url !== '/' ? trim($url, '/') : '/', $namespace, $action];
    }

    private static function findNamespace()
    {
        if (!empty(self::$group)) {
            for ($i = count(self::$group) - 1; $i >= 0; $i--) {
                if (array_key_exists('namespace', self::$group[$i])) {
                    return __NAMESPACE_CTRL__ . '\\' . self::$group[$i]['namespace'];
                }
            }
        }
        return __NAMESPACE_CTRL__;
    }

    private static function registryMiddleware($middleware)
    {
        if (!empty(self::$group)) {
            $listMiddleware = [];
            foreach (self::$group as $group) {
                if (array_key_exists('middleware', $group)) {
                    if (!is_array($group['middleware'])) {
                        $listMiddleware[] = $group['middleware'];
                    } else {
                        $listMiddleware = array_merge($listMiddleware, $group['middleware']);
                    }
                }
            }
            if (!empty($listMiddleware)) {
                $middleware->middleware($listMiddleware);
            }
        }
    }

    static function get($url, $action)
    {
        self::addRouter('GET', $url, $action);
        $middleware = new Middleware($url);
        self::registryMiddleware($middleware);
        return $middleware;
    }

    static function post($url, $action)
    {
        self::addRouter('POST', $url, $action);
        $middleware = new Middleware($url);
        self::registryMiddleware($middleware);
        return $middleware;
    }

    static function any($url, $action)
    {
        self::addRouter('GET|POST', $url, $action);
        $middleware = new Middleware($url);
        self::registryMiddleware($middleware);
        return $middleware;
    }

    private function callAction($action, $param)
    {
        if (is_callable($action)) {
            call_user_func_array($action, $param);
        }
        if (is_string($action)) {
            $ctl = explode('@', $action, 2);
            $methodName = end($ctl) ?? '';
            $file = str_replace('\\', '/', self::$namespace . '/' . reset($ctl) . 'Controller.php');
            if (file_exists(__DIR_ROOT__ . '/' . $file)) {
                $className = self::$namespace . '\\' . reset($ctl) . "Controller";
                if (class_exists($className) && method_exists($className, $methodName)) {
                    Session::flash('controller', reset($ctl));
                    Session::flash('action', $methodName);
                    $className = new $className;
                    call_user_func_array([$className, $methodName], $param);
                } else {
                throw new E("$className hoặc $methodName() không tồn tại!");
//                    echo "loi class hoac method";
                }
            } else {
//                response ve 404
                E::loadError('404');
            }

        }
//        return "response()";
    }

    private function map()
    {
        $requestMethod = self::getRequestMethod();
        $requestURI = self::getRequestURL();
        $params = [];
        foreach (self::$routers as $route) {
            list($method, $url, $namespace, $action) = $route;
            self::$namespace = $namespace;

            if (strpos($method, $requestMethod) === false) {
                continue;
            }
            if ($url !== '*') {
                if (count(explode('/', $requestURI)) > count(explode('/', $url))) {
                    continue;
                }
                if (strpos($url, '{') === false) {
                    if (strcmp(strtolower($url), strtolower($requestURI)) !== 0) {
                        continue;
                    }
                } else {
                    $path = trim(substr($url, 0, strpos($url, '{')), '/');
                    $requestURL = trim(substr($requestURI, 0, strpos($url, '{')), '/');
                    if (strcmp(strtolower($path), strtolower($requestURL)) !== 0) {
                        continue;
                    }
                    $listParamName = explode('/', trim(substr($url, strpos($url, '{')), '/'));
                    $listParamValue = explode('/', trim(substr($requestURI, strpos($url, '{')), '/'));
                    foreach ($listParamValue as $k => $val) {
                        if (preg_match('/^{\w+}$/', $listParamName[$k])) {
                            $params[] = $val;
                        }
                    }
                }
            }
            return $this->callAction($action, $params);

        }
    }

    public static function group($actionGroup, $registry)
    {
        self::registryGroup($actionGroup);
        if (is_callable($registry)) {
            call_user_func($registry);
        }
        self::outGroup();
    }

    private static function registryGroup($registry)
    {
        self::$group[] = $registry;
    }

    private static function outGroup()
    {
        $group = self::$group;
        unset($group[count($group) - 1]);
        $group = array_values($group);
        self::$group = $group;
    }

    public static function redirect($request)
    {
        $response = new Response();
        $response->redirect($request);
    }

    public function run()
    {
        $this->map();
    }
}
