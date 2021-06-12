<?php

namespace app\core;

use app\Exceptions\AppException as E;

class Cookie
{
    /**
     * @param $key
     * @param string $value
     */
    public static function data($key, $value = null, $time = 3600)
    {
        $cookieKey = self::isInvalid();
        if (isset($value)) {
            setcookie($cookieKey . '_' . $key, $value, time() + $time);
            return true;
        } else {
            if (isset($_COOKIE[$cookieKey . '_' . $key])) {
                return ($_COOKIE[$cookieKey . '_' . $key]);
            } else {
                return false;
            }
        }
    }

    public static function delete($key)
    {
        $cookieKey = self::isInvalid();
        if (isset($key)) {
            if (isset($_COOKIE[$cookieKey . '_' . $key])) {
                setcookie($cookieKey . '_' . $key, "", time() - 3600);
            }
        }
        return false;
    }

    private static function showError($mess)
    {
        //cais nay la trang load loi cua middleware
        E::loadError('exception', $mess);
    }

    private static function isInvalid()
    {
        return Registry::getIntance()->cache['cookie_key'] ?? self::showError("Lỗi Cookies");
    }
}
