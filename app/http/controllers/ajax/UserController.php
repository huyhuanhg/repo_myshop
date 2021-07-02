<?php


namespace app\http\controllers\ajax;


use app\core\Controller;

class UserController extends Controller
{
    private $userObj;
    public function __construct()
    {
        parent::__construct();
        $this->userObj = $this->model('UserModel');
    }
    public function employeeAlert(){
        self::view('user/employees/alert');
    }
    public function searchEpl(){
        if (isset($_POST['key'])) {
            $key = $_POST['key'];
            $data['employees'] = dejson($this->userObj->searchEpl($key));
            self::view('user/employees/search', $data);
        }
    }
    public function filterEpl()
    {
        $dataPost = $this->request->__dataField;
        $isBlacklist = dejson($dataPost['blacklist']);
        $data['employees'] = dejson($this->userObj->filterEpl($dataPost['key'], $isBlacklist));
        self::view('user/employees/staff-list', $data);
    }
}