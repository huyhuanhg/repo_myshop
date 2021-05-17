<?php
require_once dirname(__DIR_PUBLIC__) . "/app/core/Autoload.php";
$config_dir = scandir(dirname(__DIR_PUBLIC__) . '/config');
$config = Autoload::loadDataSpecified($config_dir);
foreach ($config['web'] as $key => $value){
    if (preg_match("~^(__)~is", $key)){
        define($key, $value);
    }
}
