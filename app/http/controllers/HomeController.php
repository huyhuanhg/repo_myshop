<?php


namespace app\http\controllers;

use app\core\Controller;

class HomeController extends Controller
{
    private $productObj;

    public function __construct()
    {
        parent::__construct();
        $this->productObj = $this->model('ProductModel');
    }

    public function index()
    {
        $data['_page_title'] = "Smartphone Shop";
        self::render('index', $data);
    }


}
