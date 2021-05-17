<?php

namespace app\core;
abstract class Model extends Database
{
public function __construct()
{
    parent::__construct();
    //viet middle ware
}
//viet cac function cac file model dung lai
abstract public function getAll();
abstract public function getById($id);
}

