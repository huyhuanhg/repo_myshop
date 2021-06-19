<?php

use app\core\Session;

$sessionKey = Session::isInvalid();
if (!function_exists('loadMsgError')){
    $GLOBALS['msg_errors'] = Session::flash($sessionKey . "_errors");
    function loadMsgError(){
        global $msg_errors;
        return json_encode($msg_errors);
    }
}
if (!function_exists('formError')) {
    $GLOBALS['errors'] = Session::flash($sessionKey . "_errors");
    function formError($fieldName, $beffore = '<div class="invalid-feedback">', $after = '</div>')
    {
        global $errors;
        $fieldNameArr = explode('|', $fieldName);
        foreach ($fieldNameArr as $field) {
            if (isset($errors) && array_key_exists($field, $errors)) {
                return $beffore . $errors[$field] . $after;
            }
        }
        return null;
    }
}
if (!function_exists('invalid')) {
    function invalid($fieldName)
    {
        global $errors;
        $fieldNameArr = explode('|', $fieldName);
        foreach ($fieldNameArr as $field) {
            if (isset($errors) && array_key_exists($field, $errors)) {
                return 'invalid';
            }
        }
        return null;
    }
}
if (!function_exists('validated')) {
    function validated()
    {
        global $errors;
        if (isset($errors)) {
            echo 'was-validated';
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
    function msg_login($htmlBefore = '<div class="invalid-feedback">', $htmlAfter = '</div>')
    {
        global $login_error;
        if (isset($login_error)) {
            echo $htmlBefore . $login_error . $htmlAfter;
        }
    }
}
if (!function_exists('selected')) {
    function selected($fieldName, $value, $default = null)
    {
        global $current;
        if (isset($current) && array_key_exists($fieldName, $current)) {
            if ($current[$fieldName] == $value) {
                return 'selected';
            }
        } else {
            if (isset($default) && $default == $value) {
                return 'selected';
            }
        }
    }
}
