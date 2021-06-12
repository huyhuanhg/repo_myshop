<?php

use app\core\Session;
use app\core\Template;

if (!function_exists('view')) {
    function view($path, $data = [])
    {
        \app\core\Controller::view($path, $data);
    }
}
if (!function_exists('raw')) {
    function raw($content, $data = [])
    {
        $template = new Template();
        $template->run($content, $data);
    }
}
if (!function_exists('logout')) {
    function logout()
    {
        $sessionKey = Session::isInvalid();
        $user = Session::data($sessionKey . '_user');
        if (isset($user)) {
            return '<a href="' . __WEB_ROOT__ . '/logout">Đăng xuất</a>';
        }
    }
}
?>

