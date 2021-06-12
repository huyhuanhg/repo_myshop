<?php


namespace app\http\controllers\admin;


use app\core\Controller;

class CustomerController extends Controller
{

    private $customerObj;

    public function __construct()
    {
        parent::__construct();
        $this->customerObj = $this->model('CustomerModel');
    }

    public function index()
    {
        if (isset($_GET['cp'])) {
            $phone = $_GET['cp'];
            if (!empty($phone)){
                $data['main'] = dejson($this->customerObj->getById($phone));
                $data['_page_title'] = 'Chi tiết khách hàng';
                self::render('detail', $data, 'admin/main');
            } else{
                $this->redirect('/myadmin/customers');
            }
        } else {
            $data['main']['customers'] = dejson($this->customerObj->getAll());
            $data['_page_title'] = 'Khách hàng';
            self::render('index', $data, 'admin/main');
        }
    }
}