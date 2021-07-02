<?php


namespace app\http\controllers\ajax;


use app\core\Controller;

class CustomerController extends Controller
{

    private $customerObj;

    public function __construct()
    {
        parent::__construct();
        $this->customerObj = $this->model('CustomerModel');
    }


    public function search()
    {
        if (isset($_POST['key'])) {
            $key = $_POST['key'];
            $data['customers'] = dejson($this->customerObj->search($key));
            self::view('customer/search', $data);
        }
    }

    public function filter()
    {
        $dataPost = $this->request->__dataField;
        $isBlacklist = dejson($dataPost['blacklist']);
        $data['customers'] = dejson($this->customerObj->filter($dataPost['key'], $isBlacklist, $dataPost['sort']));
        self::view('customer/list', $data);
    }

    public function alert()
    {
        $data['control'] = $_POST['control'];
        $data['sdt'] = $_POST['sdt'];
        $fullName = $_POST['fullName'];
        switch ($data['control']){
            case 'delete':{
                $data['message']= "Bạn muốn xóa khách hàng: $fullName";
                break;
            }
            case 'blacklist':{
                $data['current'] = $_POST['current'];
                $msg = $data['current'] === "LIMITED" ? "Bạn muốn xóa \"$fullName\" khỏi danh sách hạn chế?"
                    :"Bạn muốn thêm \"$fullName\" vào danh sách hạn chế?";
                $data['message']= $msg;
                break;
            }
        }

        self::view('customer/alert', $data);
    }
}