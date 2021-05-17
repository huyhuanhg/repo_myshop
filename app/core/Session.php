<?php

namespace app\core;
use app\Exceptions\AppException as E;

class Session
{
    /**
     * @param $key
     * @param string $value
     */
    public static function data($key = null, $value = null)
    {
        $sessionKey = self::isInvalid();
        if (isset($value)) {
            if (!empty($key)) {
                $_SESSION[$sessionKey][$key] = $value;
                return true;
            }
            return false;
        } else {
            if (isset($key)) {
                if (isset($_SESSION[$sessionKey][$key])) {
                    return $_SESSION[$sessionKey][$key];
                }
            } else {
                if (isset($_SESSION[$sessionKey])) {
                    return $_SESSION[$sessionKey];
                }
            }
        }
    }

    public static function flash($key = null, $value = null)
    {
        $dataFlash = self::data($key, $value);
        if (!isset($value)) {
            self::delete($key);
        }
        return $dataFlash;
    }

    public static function delete($key = null)
    {
        $sessionKey = self::isInvalid();
        if (isset($key)) {
            if (isset($_SESSION[$sessionKey][$key])) {
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
        } else {
            unset($_SESSION[$sessionKey]);
            return true;
        }
        return false;
    }

    private static function showError($mess)
    {
        //cais nay la trang load loi cua middleware
        E::loadError('exception', $mess);
    }

    public static function isInvalid()
    {
        return Registry::getIntance()->session['session_key'] ?? self::showError("loi session");
    }
}
