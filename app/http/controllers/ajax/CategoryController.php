<?php


namespace app\http\controllers\ajax;


use app\core\Controller;

class CategoryController extends Controller
{
    private $categoryObj;
    private $productObj;

    public function __construct()
    {
        parent::__construct();
        $this->categoryObj = $this->model('CategoryModel');
        $this->productObj = $this->model('ProductModel');
    }


    public function filter()
    {
        if (isset($_POST['active']) && isset($_POST['key'])) {
            $key = $_POST['key'];
            if ($_POST['active'] !== 'all') {
                $active = (int)$_POST['active'];
                $data['categories'] = $this->categoryObj->filter($key, $active);
            } else {
                $data['categories'] = $this->categoryObj->filter($key);
            }
            self::view('category/list', $data);
        }

    }

    public function formAdd()
    {
        self::view('category/form-add');
    }

    public function formEdit()
    {
        self::view('category/form-edit');
    }

    public function warring()
    {
        $data['categoryID'] = $_POST['categoryID'];
        $title = $_POST['category_title'];
        $countProductOfCategory = count(dejson($this->productObj->getAllProductByCategory($data['categoryID'])));
        $data['message'] = 'Mặt hàng: ' . $title;
        if ($countProductOfCategory > 0) {
            $data['message'] .= ' có ' . $countProductOfCategory . 'sản phẩm.';
        }
        $data['message'] .= '<br/>Bạn có chắc chắn muốn xóa?';
        self::view('category/warning-delete', $data);
    }
}