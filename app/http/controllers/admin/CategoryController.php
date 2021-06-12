<?php


namespace app\http\controllers\admin;


use app\core\Controller;
use app\core\Session;

class CategoryController extends Controller
{
    private $categoryObj;

    public function __construct()
    {
        parent::__construct();
        $this->categoryObj = $this->model('CategoryModel');
    }

    public function index()
    {
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'add':
                {
                    $data['_page_title'] = 'Thêm hãng sản phẩm';
                    self::render('form-add', $data, 'admin/main');
                    break;
                }
                case 'edit':
                {
                    if (isset($_GET['id'])) {
                        $data['main']['category'] = dejson($this->categoryObj->getById($_GET['id']));
                        $data['_page_title'] = 'Sửa hãng sản phẩm';
                        self::render('form-edit', $data, 'admin/main');
                    } else {
                        $this->redirect('/myadmin/categories');
                    }
                    break;
                }
                default:
                {
                    $this->redirect('/myadmin/categories');
                }
            }
        } else {
            $data['main']['categories'] = dejson($this->categoryObj->getAll());
            $data['_page_title'] = 'Hãng sản phẩm';
            self::render('index', $data, 'admin/main');
        }
    }

    public function insert()
    {
        $data = $this->request->__dataField;
        $maxID = $this->categoryObj->getMaxID();
        $data['category_active'] = (int)$data['category_active'];
        $data['category_not_mark'] = convert_vi_to_lt($data['category_title']);
        $data['categoryID'] = setCategoryID($maxID);
        unset($data['submit']);
        $status = $this->categoryObj->insert($data);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/categories');
    }

    public function update()
    {
        $data = $this->request->__dataField;
        $data['category_active'] = (int)$data['category_active'];
        $data['category_not_mark'] = convert_vi_to_lt($data['category_title']);
        unset($data['submit']);
        unset($data['currentTitle']);
        $status = $this->categoryObj->update($data);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/categories');
    }

    public function delete()
    {
        //chú ý xóa category sẽ ảnh hưởng đến khóa ngoại
        $status = $this->categoryObj->delete($this->request->__dataField['categoryID']);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/categories');
    }
}