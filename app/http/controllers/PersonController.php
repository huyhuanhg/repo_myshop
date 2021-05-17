<?php


namespace app\http\controllers;


use app\core\Controller;
use app\core\Registry;
use app\core\Session;

class PersonController extends Controller
{
    private $personObj;

    public function __construct()
    {
        parent::__construct();
        $this->personObj = $this->model('PersonModel');
    }

    public function index()
    {
        $data['person'] = json_decode($this->personObj->getAll());
        $this->render('index', $data);
    }

    public function add()
    {
        $this->render('add');
    }

    public function handleAdd()
    {
        $sessionKey = Session::isInvalid();
        $data = Session::flash($sessionKey . '_add_person');
        if (array_key_exists('add', $data)) {
            unset($data['add']);
        }
        $status = $this->personObj->add($data);
        if ($status) {
            Session::flash($sessionKey . '_msg_valid', 'Thêm thành công!');
        } else {
            Session::flash($sessionKey . '_msg_error', 'Thêm thất bại!');
        }

        $this->redirect('person');
    }


    public function deleteView()
    {
        //if là nhiệm vụ của middleware
        if (array_key_exists('id', $this->request->__dataField) && !empty($this->request->__dataField['id'])) {
            $personID = $this->request->__dataField['id'];
            $data['person_name'] = json_decode($this->personObj->getPersonByID($personID));
            $this->render('delete', $data);
        } else {
            $this->redirect('person');
        }
    }

    public function handleDelete()
    {
        $sessionKey = Session::isInvalid();
        $data = $this->request->__dataField;
        if (!array_key_exists('delete', $data)) {
            $this->redirect('person');
        } else {
            if (array_key_exists('id', $data) && !empty($data['id'])) {
                $status = $this->personObj->delete($data['id']);
            } else {
                $this->redirect('person');
            }
            if ($status) {
                Session::flash($sessionKey . '_msg_valid', 'Xóa thành công!');
            } else {
                Session::flash($sessionKey . '_msg_error', 'Xóa thất bại!');
            }
            $this->redirect('person');
        }
    }

    public function editView()
    {
        if (array_key_exists('id', $this->request->__dataField) && !empty($this->request->__dataField['id'])) {
            $personID = $this->request->__dataField['id'];
            $data['person'] = json_decode($this->personObj->getPersonByID($personID));
            $this->render('edit', $data);
        } else {
            $this->redirect('person');
        }
    }

    public function handleEdit()
    {
        $sessionKey = Session::isInvalid();
        $data = Session::flash($sessionKey . '_edit_person');
        if (array_key_exists('edit', $data)) {
            unset($data['edit']);
        }
        unset($data['edit']);
        if (array_key_exists('id', $data) && !empty($data['id'])) {
            $status = $this->personObj->edit($data);
            if ($status) {
                Session::flash($sessionKey . '_msg_valid', 'Sửa thành công!');
            } else {
                Session::flash($sessionKey . '_msg_error', 'Sửa thất bại!');
            }
        }
        $this->redirect('person');
    }
}
