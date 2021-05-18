<?php

namespace app\core;
use app\Exceptions\AppException as E;

abstract class ServiceProvider
{
    abstract public function boot();
    public static function loadDatashare(){
        $boots = Registry::getIntance()->app['boot'];
        if (!empty($boots)) {
            foreach ($boots as $serviceName) {
                $path = str_replace('\\','/',$serviceName);
                if (file_exists(__DIR_ROOT__."/$path.php")) {
                    if (class_exists($serviceName)) {
                        $serviceObj = new $serviceName();
                        call_user_func([$serviceObj, 'boot']);
                    } else {
                        throw new E("$serviceObj không tồn tại!");
                    }
                } else {
                    E::loadError('404');
                }
            }
        }
    }
}