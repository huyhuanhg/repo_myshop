<?php


namespace app\http\middlewares;

use app\core\BeforeMiddleware as Middleware;
use app\core\Registry;
use app\core\Session;

class ValidateMiddleware extends Middleware
{

    public function validate_register()
    {
        $data = $this->request->__dataField;
        $this->request->rules([
            'account' => 'required|unique:users:account|notMatches:\W+|notMatches:^\d(.+?)',
            'firstName' => 'required',
            'lastName' => 'required',
            'birthday' => 'required|date',
            'gender' => 'required',
            'phone' => 'required|matches:^0[0-9]{9}',
            'password' => 'required',
            'confirm_password' => 'required|equal:password',
            'confirm' => 'required'
        ]);
        $this->request->message([
            'account.required' => 'Vui lòng nhập tài khoản!',
            'account.unique' => 'Tài khoản đã tồn tại!',
            'firstName.required' => 'Vui lòng nhập họ tên!',
            'lastName.required' => 'Vui lòng nhập họ tên!',
            'birthday.date' => 'Định dạng ngày sinh không đúng!',
            'birthday.required' => 'Vui lòng chọn ngày sinh!',
            'gender.required' => 'Vui lòng chọn giới tính!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.matches' => 'Định dạng số điện thoại không đúng!',
            'account.notMatches' => 'Tài khoản phải bắt đầu bằng chữ cái!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'confirm_password.equal' => 'Nhập lại mật khẩu không đúng!',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            parent::handle('/register', function ($request) {
                $this->redirect($request);
            });
        }
        unset($data['confirm_password']);
        unset($data['confirm']);
        $data['gender'] = (int)$data['gender'];
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['level'] = 0;
        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey . '_data_register', $data);
    }

    public function validate_insertCategory()
    {
        $this->validateCategory('/myadmin/categories?page=add');
    }


    public function validate_updateCategory()
    {
        $this->validateCategory('/myadmin/categories?page=edit&id=' . $this->request->__dataField['categoryID']);
    }

    public function validate_deleteCategory()
    {
        $id = $this->request->__dataField['categoryID'];
        if (isset($id)) {
            $this->request->rules([
                'categoryID' => 'exist:categories:categoryID',
            ]);
            $validate = $this->request->validate();
            if (!$validate) {
                parent::handle('/myadmin/categories', function ($request) {
                    $this->redirect($request);
                });
            }
        }
    }

    private function validateCategory($uri)
    {
        if (isset($this->request->__dataField['cancel'])) {
            parent::handle('/myadmin/categories', function ($request) {
                $this->redirect($request);
            });
        }
        $check = 'required|unique:categories:category_title';
        if (isset($this->request->__dataField['currentTitle'])) {
            $check .= ':' . $this->request->__dataField['currentTitle'];
        }
        $this->request->rules([
            'category_title' => $check,
            'category_active' => 'required',
        ]);
        $this->request->message([
            'category_title.required' => 'Vui lòng nhập tên hãng sản phẩm!',
            'category_title.unique' => 'Hãng sản phẩm đã tồn tại!',
            'category_active.required' => 'Vui lòng chọn tình trạng!',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            parent::handle($uri, function ($request) {
                $this->redirect($request);
            });
        }
    }
}
