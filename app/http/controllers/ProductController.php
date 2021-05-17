<?php


namespace app\http\controllers;

use app\core\Controller;
class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        self::render('index');
    }
    public function list(){
    }
}
