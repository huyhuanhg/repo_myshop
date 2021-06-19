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
        if (!empty($data)) {
            $data = json_encode(reset($data));
        }
        return $data;
    }

    public function search($key)
    {
        $data = DB::table(self::__TABLE__)->where('customer_phone', '=', $key)
            ->orWhere('customer_email', '=', $key)
            ->orWhere('customer_fullName', 'LIKE', "%$key%")->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    public function filter($key, $blacklist, $sort)
    {
        $sql = DB::table(self::__TABLE__);
        if (isset($key)) {
            $GLOBALS['key'] = $key;
            $sql = $sql->where(function ($query) {
                global $key;
                $query->where('customer_phone', '=', $key)
                    ->orWhere('customer_email', '=', $key)
                    ->orWhere('customer_fullName', 'LIKE', "%$key%");
            });
        }
        if ($blacklist) {
            $sql = $sql->where('customer_status', '=', 'LIMITED');
        }
        if (!empty($sort)) {
            $sql = $sql->orderBy('consume', $sort);
        }
        return json_encode($sql->get()->fetchAll(PDO::FETCH_ASSOC));
    }

    public function insert($data)
    {
        return DB::table(self::__TABLE__)->insert($data);
    }

    public function update($data)
    {
        $sdt = $data['curent_sdt'];
        unset($data['curent_sdt']);
        return DB::table(self::__TABLE__)->where('customer_phone', '=', $sdt)->update($data);
    }

    public function delete($sdt)
    {
        /**
         * Chú ý khóa ngoại, sẽ update sau
         */
        return DB::table(self::__TABLE__)->where('customer_phone', '=', $sdt)->delete();
    }

    public function blacklistToggle($data)
    {
        $sql = DB::table(self::__TABLE__)->where('customer_phone', '=', $data['customer_phone']);
        if ($data['customer_status'] !== "LIMITED") {
            return $sql->update(['customer_status' => "LIMITED"]);
        } else {
            return $sql->update(['customer_status' => '']);
        }
    }
}