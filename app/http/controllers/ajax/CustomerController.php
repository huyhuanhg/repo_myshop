<?php


namespace app\http\controllers\ajax;


use app\core\Controller;

class CustomerController extends Controller
{

    private $customerObj;
//    private $productObj;

    public function __construct()
    {
        parent::__construct();
        $this->categoryObj = $this->model('CustomerModel');
//        $this->productObj = $this->model('ProductModel');
    }


    public function search(){
        if (isset($_POST['key'])) {
            $key = $_POST['key'];
            echo $key;
        }
    }
}