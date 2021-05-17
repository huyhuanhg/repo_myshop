<?php


namespace app\http\controllers;
use app\core\Controller;

class HomeController extends Controller
{
    private $personObj;
    public function __construct()
    {
        parent::__construct();
        $this->personObj = $this->model('PersonModel');
    }
    public function index(){
        self::render('index');
    }
    public function checkQuery(){
        $data['sql'] = $this->personObj->checkQuery();
        self::view('test', $data);
    }
    public function register(){
        self::render('register');
    }
}
