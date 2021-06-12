<?php


namespace app\http\controllers;

use app\core\Controller;

class UserformController extends Controller
{

    public function login()
    {
        $data['_page_title'] = "Đăng nhập";
        self::render('login', $data, 'userform');
    }

    public function register()
    {
        $data['_page_title'] = "Đăng ký thành viên";
        self::render('register', $data, 'userform');
    }
    public function getLoginPage()
    {
        self::view('userform/login');
    }
}