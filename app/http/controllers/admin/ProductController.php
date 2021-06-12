<?php


namespace app\http\controllers\admin;


use app\core\Controller;

class ProductController extends Controller
{

    private $productObj;

    public function __construct()
    {
        parent::__construct();
        $this->productObj = $this->model('ProductModel');
    }

    public function index()
    {
//        $data['categories'] = $this->categoryObj->getAll();
        $data['_page_title'] = 'Sản phẩm';
        self::render('index', $data, 'admin/main');
    }
}