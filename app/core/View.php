<?php

namespace app\core;
class View
{
    public static $dataShare = [];
    public static function share($data){
        self::$dataShare = $data;
    }
}