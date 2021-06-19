<?php


namespace app\http\middlewares;

use app\core\BeforeMiddleware as Middleware;
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

    public function validate_customer()
    {
        $data = $this->request->__dataField;
        if (array_key_exists('cancel', $data)) {
            switch ($data['cancel']) {
                case 'add':
                {
                    parent::handle('/myadmin/customers', function ($request) {
                        $this->redirect($request);
                    });
                    break;
                }
                case 'edit':
                {
                    parent::handle("/myadmin/customers?cp=" . $data['curent_sdt'], function ($request) {
                        $this->redirect($request);
                    });
                    break;
                }
            }
        }
        $rules = [
            'customer_fullName' => 'required',
            'customer_phone' => 'required|matches:^0[0-9]{9}',
            'customer_address' => 'required',
        ];
        if ($data['submit'] === 'add') {
            $rules['customer_phone'] .= '|unique:Customers:customer_phone';
        }
        if ($data['customer_email'] !== '') {
            $rules['customer_email'] = 'email';
        }
        $this->request->rules($rules);
        $this->request->message([
            'customer_fullName.required' => 'Vui lòng nhập tên khách hàng!',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại!',
            'customer_phone.unique' => 'Khách hàng có số điện thoại này đã tồn tại!',
            'customer_phone.matches' => 'Sai định dạng số điện thoại! (0xxx xxx xxx)',
            'customer_address.required' => 'Vui lòng nhập địa chỉ khách hàng!',
            'customer_email.email' => 'Định dạng email không chính xác!',
        ]);
        $validate = $this->request->validate();
        if (!$validate) {
            $uri = "/myadmin/customers?page=" . $data['submit'];
            $uri .= $data['submit'] === 'edit' ? '&sdt=' . $data['curent_sdt'] : '';
            parent::handle($uri, function ($request) {
                $this->redirect($request);
            });
        }
//        handle data
        unset($data['submit']);

        if (!$data['customer_gender'] !== '') {
            $data['customer_gender'] = (int)$data['customer_gender'];
        }
        if (empty($data['customer_birthday'])) {
            unset($data['customer_birthday']);
        }
        if (empty($data['customer_email'])) {
            unset($data['customer_email']);
        }
        if (empty($data['customer_status'])) {
            unset($data['customer_status']);
        }
        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey . "_data", $data);
    }
}
