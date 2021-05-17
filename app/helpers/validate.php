<?php

use app\core\Session;

$sessionKey = Session::isInvalid();
if (!function_exists('formError')) {
    $GLOBALS['errors'] = Session::flash($sessionKey . "_errors");
    function formError($fieldName, $beffore = null, $after = null)
    {
        global $errors;
        if (isset($errors) && array_key_exists($fieldName, $errors)) {
            echo $beffore . $errors[$fieldName] . $after;
        }
        return null;
    }
}
if (!function_exists('formCurrentValue')) {
    $GLOBALS['current'] = Session::flash($sessionKey . "_current");
    function formCurrentValue($fieldName, $deflaut = null)
    {
        global $current;
        if (isset($current) && array_key_exists($fieldName, $current)) {
            return $current[$fieldName];
        }
        return $deflaut;
    }
}
if (!function_exists('logout')) {
    function logout()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey . '_user');
        if (isset($user)) {
            echo '<div style="float: right; margin-right: 30px; font-size: 150%"><a href="' . __WEB_ROOT__ . '/logout">Logout</a></div>';
        }
    }
}
if (!function_exists('msg')) {
    $GLOBALS['msg'] = Session::flash($sessionKey . "_msg_error") ?? Session::flash($sessionKey . "_msg_valid");
    function msg($htmlBefore = '', $htmlAfter = '')
    {
        echo $htmlBefore . $GLOBALS['msg'] . $htmlAfter;
    }
}
if (!function_exists('msg_login')) {
    $GLOBALS['login_error'] = Session::flash($sessionKey . "_login_msg_error");
    function msg_login($htmlBefore = '', $htmlAfter = '')
    {
        echo $htmlBefore . $GLOBALS['login_error'] . $htmlAfter;
    }
}
if (!function_exists('selected')) {
    function selected($fieldName, $value)
    {
        global $current;
        if (isset($current) && array_key_exists($fieldName, $current)) {
            if ($current[$fieldName] == $value) {
                return 'selected';
            } else {
                return null;
            }
        }
    }
}
if (!function_exists('gender')) {
    function gender($genderBool)
    {
        return $genderBool == 1 ? 'Nam' : 'Nữ';
    }
}
if (!function_exists('currentSelected')) {
    function currentSelected($fieldName, $default)
    {
        global $current;
        if (isset($current) && array_key_exists($fieldName, $current)) {
            return $current[$fieldName];
        }
        return $default;
    }
}
if (!function_exists('personGender')) {
    function personGender($personGender, $value)
    {
        if ($personGender == $value) {
            return 'selected';
        } else {
            return null;
        }
    }
}
