<?php

namespace app\http\controllers\admin;

use app\core\Controller;
use app\core\Cookie;
use app\core\Session;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model('UserModel');
    }

    public function index()
    {
        $data['_page_title'] = "Quản lý cửa hàng";
        self::render('index', $data, 'admin/main');
    }

    public function login()
    {
        $data = $this->request->__dataField;
        $remeber = false;
        if (isset($data['remember'])) {
            $remeber = true;
            unset($data['remember']);
        }
        $user = $this->userModel->user_exists($data);
        $sessionKey = Session::isInvalid();
        if ($user) {
            if ($remeber) {
                Cookie::data('user', $user, 86400 * 30);
            } else {
                Cookie::delete('user');
            }
            Session::data($sessionKey . '_user', $user);
            $this->redirect('/myadmin');
        }
        Session::flash($sessionKey . '_login_msg_error', 'Tài khoản hoặc mật khẩu không đúng!');
        $this->redirect('/login');
    }

    public function register()
    {
        $sessionKey = Session::isInvalid();
        $data = Session::flash($sessionKey . '_data_register');
        $status = $this->userModel->register($data);
        if ($status) {
            Session::flash($sessionKey . '_msg_valid', 'Đăng ký thành công!');
            $this->redirect('/login');
        } else {
            Session::flash($sessionKey . '_msg_error', 'Đăng ký thất bại');
            $this->redirect('/register');
        }
    }

    public function logout()
    {
        $sessionKey = Session::isInvalid();
        Session::delete($sessionKey . '_user');
        Cookie::delete('user');
        $this->redirect('/login');
    }

    public function staff()
    {
//        $data['categories'] = $this->categoryObj->getAll();
        $data['_page_title'] = 'Nhân viên';
        self::render('staff', $data, 'admin/main');
    }
}
