<?php


use app\core\Model as DB;

class ProductModel extends DB
{
    const __TABLE__ = 'products';

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function getAllProductByCategory($categoryID)
    {
        $data = DB::table(self::__TABLE__)->select('productID')->where('categoryID', '=', $categoryID)->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }
}