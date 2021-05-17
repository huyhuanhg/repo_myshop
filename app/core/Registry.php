<?php


namespace app\core;


class Registry
{

    private static $intance;
    private $storage;

    private function __construct()
    {
    }

    public static function getIntance()
    {
        if (!isset(self::$intance)) {
            self::$intance = new self();
        }
        return self::$intance;
    }

    public function __get($name)
    {
        if (isset($this->storage[$name])) {
            return $this->storage[$name];
        }
        return null;
    }

    public function __set($name, $value = null)
    {
        if (!isset($this->storage[$name]) && isset($value)) {
            $this->storage[$name] = $value;
        }
    }
}
