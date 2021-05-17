<?php

require_once(dirname(__FILE__) . '/Autoload.php');

use app\core\Registry;
use app\core\Router;

class App
{
    private $router;

    public function __construct()
    {
        global $config;
        new Autoload($config['web']['fileDefault']);
        foreach ($config as $item => $value) {
            Registry::getIntance()->$item = $value;
        }
        $this->router = new Router();
        $this->router->run();
    }

    public static function run()
    {
        new App();
    }
}
