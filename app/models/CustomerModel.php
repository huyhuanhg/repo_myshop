<?php


use app\core\Model as DB;

class CustomerModel extends DB
{
    const __TABLE__ = 'Customers';

    public function getAll()
    {
        // TODO: Implement getAll() method.
        $data = DB::table(self::__TABLE__)->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        $data = DB::table(self::__TABLE__)->where('customer_phone', '=', $id)->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode(reset($data));
    }
}