<?php

namespace app\http\controllers\admin;

use app\core\Controller;
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
        $data = $this->userModel->getAll();
        echo "<pre>";
        print_r(json_decode($data));
    }

    public function login()
    {
        $data = $this->request->__dataField;
        $user = $this->userModel->user_exists($data);
        $sessionKey = Session::isInvalid();
        if ($user) {
            Session::data($sessionKey . '_user', $user['account']);
            $this->redirect('/person');
        }
        Session::flash($sessionKey . '_login_msg_error', 'Tai khoan hoac mat khau khong dung!');
        $this->redirect('/');
    }

    public function logout()
    {
        $sessionKey = Session::isInvalid();
        Session::delete($sessionKey . '_user');
        $this->redirect('/');
    }
    public function registry(){
        $sessionKey = Session::isInvalid();
        $data = $this->request->__dataField;
        unset($data['pass_confonfirm']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $status = $this->userModel->registry($data);
        if ($status) {
            Session::data($sessionKey . '_user', $data['account']);
            Session::flash($sessionKey . '_msg_valid', 'Đăng ký thành công!');
            $this->redirect('/person');
        } else {
            Session::flash($sessionKey . '_msg_error', 'Đăng ký thất bại');
            $this->redirect('/signin');
        }
    }
    public function account_exists($user)
    {
        $check = $user->rowCount();
        if ($check === 1) {
            return true;
        }
        return false;
    }
}
