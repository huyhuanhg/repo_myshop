<?php


use app\Exceptions\AppException as E;

class Autoload
{


    public function __construct($listFileDefault = null)
    {
        spl_autoload_register([$this, 'load']);
        if (isset($listFileDefault)) {
            $this->loadFileDefault($listFileDefault);
        }
    }

    private function load($class)
    {
        $filePath = str_replace('\\', '/', __DIR_ROOT__ . "/$class.php");
        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            throw new E("$filePath không tồn tại!");
        }
    }

    private function loadFileDefault($listFileDefault)
    {
        foreach ($listFileDefault as $file) {
            if (file_exists(__DIR_ROOT__ . '/' . $file)) {
                require_once(__DIR_ROOT__ . '/' . $file);
            } else {
            throw new E("$file không tồn tại!");
            }
        }
    }

    public static function loadDataSpecified($listPath)
    {
        if (!empty($listPath)) {
            foreach ($listPath as $item) {
                if ($item !== '.' && $item !== '..' && file_exists(dirname(__DIR_PUBLIC__) . "/config/$item")) {
                    $key = str_replace('.php', '', $item);
                    $config[$key] = require_once dirname(__DIR_PUBLIC__) . "/config/$item";
                }
            }
        }
        return $config;
    }
}
