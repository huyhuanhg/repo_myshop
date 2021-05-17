<?php


namespace app\http\middlewares;

use app\core\BeforeMiddleware as Middleware;
use app\core\Registry;
use app\core\Session;

class ValidateMiddleware extends Middleware
{
    public function validate_login()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/');
        }
        $this->request->rules([
            'acc' => 'required',
            'pass' => 'required'
        ]);
        $this->request->message([
            'acc.required' => 'vui long nhap tai khoan',
            'pass.required' => 'vui long nhap mat khau'
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            $this->redirect('/');
        }
    }

    public function validate_registry(){

        if (!$this->request->isPost()) {
            $this->redirect('/');
        }
        $this->request->rules([
            'account' => 'required|unique:users:account',
            'password' => 'required',
            'pass_confonfirm' => 'equal:password',
        ]);
        $this->request->message([
            'account.required' => 'vui long nhap tai khoan',
            'account.unique' =>'tài khoản đã tồn tại',
            'password.required' => 'vui long nhap mat khau',
            'pass_confonfirm.equal' => 'nhập lại mật khẩu không khớp!',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            $this->redirect('/signin');
        }
    }
    public function validate_add()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/person');
        }
        $sessionKey = Session::isInvalid();
        $data = $this->request->__dataField;
        if (isset($data['gender'])){
            $data['gender'] = (int)$data['gender'];
        }
        Session::flash($sessionKey . '_add_person', $data);
        if (array_key_exists('cancel', $data)) {
            $this->redirect('person');
        }
        $this->request->rules([
            'full_name' => 'required|minword:2',
            'birthday' => 'required|date',
            'email' => 'required|email',
            'number_phone' => 'required|number',
            'address' => 'required',
            'gender' => 'required'
        ]);
        $this->request->message([
            'full_name.required' => 'Vui lòng nhập họ tên!',
            'email.required' => 'Vui lòng nhập email!',
            'birthday.required' => 'Vui lòng nhập ngay!',
            'email.email' => 'Định dạng email không chính xác!',
            'birthday.date' => 'Định dạng ngay sinh không chính xác!',
            'address.required' => 'nhap dia chi',
            'number_phone.required' => 'nhap so dien thoai',
            'number_phone.number' => 'Định dạng số điện thoại không chính xác(10 chữ số)!',
            'gender.required' => 'chọn giới tính!',
            'full_name.minword' => 'tên gồm ít nhất 2 từ',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            Session::flash($sessionKey . '_msg_error', 'Thêm thất bại!');
            $this->redirect('/person/add');
        }
    }

    public function validate_edit()
    {
        if (!$this->request->isPost()) {
            $this->redirect('/person');
        }
        $sessionKey = Session::isInvalid();
        $data = $this->request->__dataField;
        if (isset($data['gender'])){
            $data['gender'] = (int)$data['gender'];
        }
        Session::flash($sessionKey . '_edit_person', $data);
        if (array_key_exists('cancel', $data)) {
            $this->redirect('/person');
        }
        $this->request->rules([
            'full_name' => 'required|minword:2',
            'birthday' => 'required|date',
            'email' => 'required|email',
            'number_phone' => 'required|number',
            'address' => 'required',
        ]);
        $this->request->message([
            'full_name.required' => 'Vui lòng nhập họ tên!',
            'email.required' => 'Vui lòng nhập email!',
            'birthday.required' => 'Vui lòng nhập ngay!',
            'email.email' => 'Định dạng email không chính xác!',
            'birthday.date' => 'Định dạng ngay sinh không chính xác!',
            'address.required' => 'nhap dia chi',
            'number_phone.required' => 'nhap so dien thoai',
            'number_phone.number' => 'Định dạng số điện thoại không chính xác(10 chữ số)!',
            'full_name.minword' => 'tên gồm ít nhất 2 từ',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            Session::flash($sessionKey . '_msg_error', 'Thêm thất bại!');
            $this->redirect('/person/edit?id='.$data['id']);
        }
    }
}
