<?php


namespace app\http\controllers\admin;


use app\core\Controller;

class OrderController extends Controller
{

    private $orderObj;

    public function __construct()
    {
        parent::__construct();
        $this->orderObj = $this->model('OrderModel');
    }

    public function index()
    {
//        $data['categories'] = $this->categoryObj->getAll();
        $data['_page_title'] = 'Quản lý đơn hàng';
        self::render('index', $data, 'admin/main');
    }
}