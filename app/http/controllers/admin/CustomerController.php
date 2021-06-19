<?php


namespace app\http\controllers\admin;


use app\core\Controller;
use app\core\Session;

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
            if (!empty($phone)) {
                $data['main'] = dejson($this->customerObj->getById($phone));
                $data['_page_title'] = 'Chi tiết khách hàng';
                self::render('detail', $data, 'admin/main');
            } else {
                $this->redirect('/myadmin/customers');
            }
        } elseif (isset($_GET['k'])) {
            if (empty($_GET['k'])) {
                $this->redirect('/myadmin/customers');
            } else {
                $data['main']['customers'] = dejson($this->customerObj->search($_GET['k']));
                $data['_page_title'] = 'Khách hàng';
                self::render('index', $data, 'admin/main');
            }
        } elseif (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'add':
                {
                    $data['main']['control'] = "add";
                    break;
                }
                case 'edit':
                {
                    if (empty($_GET['sdt'])) {
                        $this->redirect('/myadmin/customers');
                    } else {
                        $data['main']['customer'] = $this->customerObj->getById($_GET['sdt']);
                        if (empty($data['main']['customer'])) {
                            $this->redirect('/myadmin/customers');
                        }
                    }
                    $data['main']['control'] = "edit";
                    break;
                }
                default:
                {
                    $this->redirect('/myadmin/customers');
                }
            }
            self::render('form-CRU', $data, 'admin/main');
        } else {
            $data['main']['customers'] = dejson($this->customerObj->getAll());
            $data['_page_title'] = 'Khách hàng';
            self::render('index', $data, 'admin/main');
        }
    }

    public function insert()
    {
        $data = Session::flash($this->sKey . "_data");
        $status = $this->customerObj->insert($data);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/customers');
    }

    public function update()
    {
        $data = Session::flash($this->sKey . "_data");
        $status = $this->customerObj->update($data);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/customers');
    }
    public function delete(){
        $status = $this->customerObj->delete($this->request->__dataField['customer_phone']);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/customers?cp=');
    }
    public function blacklist(){
        $data = $this->request->__dataField;
        $status = $this->customerObj->blacklistToggle($data);
        if ($status) {
            Session::flash($this->sKey . '_message', 'Thành công!');
        } else {
            Session::flash($this->sKey . '_message', 'Thất bại!');
        }
        $this->redirect('/myadmin/customers?cp='.$data['customer_phone']);

    }
}