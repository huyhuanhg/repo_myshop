<?php

use app\core\Model as DB;

class UserModel extends DB
{
    const __TABLE__ = 'users';

    public function getAll()
    {
        $data = DB::table('person')->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function getById($id)
    {
        return DB::table(self::__TABLE__)->where('account', '=', $id)->get();
    }

    public function user_exists($accountInfo)
    {
        $user = DB::table(self::__TABLE__)->where('account', '=', $accountInfo['account'])->get();
        $user = $this->fetchAssoc($user);
        if (count($user) === 1) {
            $user = reset($user);
            if (password_verify($accountInfo['password'], $user['password'])) {
                unset($user['password']);
                return json_encode($user);
            }
        }
        return false;
    }

    public function register($data)
    {
        return DB::table(self::__TABLE__)->insert($data);
    }

    public function getEmployees()
    {
        $data = DB::table(self::__TABLE__)->
        select(['account', 'firstName', 'lastName', 'phone', 'gender', 'level', 'userStatus'])
            ->where('level', '>', '0')->where('account', '<>', 'admin')->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    public function getEmployeeByID($id)
    {
        $data = DB::table(self::__TABLE__)->
        select(['account', 'firstName', 'lastName', 'phone', 'gender', 'level', 'userStatus'])
            ->where('level', '>', '0')->where('account', '=', $id)->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode(reset($data));
    }

    public function searchEpl($key)
    {
        $GLOBALS['key'] = $key;
        $data = DB::table(self::__TABLE__)
            ->select(['account', 'firstName', 'lastName', 'phone', 'gender', 'level', 'userStatus'])
            ->where('level', '>', '0')->where('account', '<>', 'admin')
            ->where(function ($query) {
                global $key;
                $query->where('firstName', '=', $key)
                    ->orWhere('lastName', 'LIKE', "%$key%")
                    ->orWhere('phone', 'LIKE', "$key%")
                    ->orWhere('email', 'LIKE', "$key%");
            })->get()->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($data);
    }


    public function filterEpl($key, $blacklist)
    {
        $sql = DB::table(self::__TABLE__)
            ->select(['account', 'firstName', 'lastName', 'phone', 'gender', 'level', 'userStatus'])
            ->where('level', '>', '0')->where('account', '<>', 'admin');
        if (isset($key)) {
            $GLOBALS['key'] = $key;
            $sql = $sql
                ->where(function ($query) {
                    global $key;
                    $query->where('firstName', '=', $key)
                        ->orWhere('lastName', 'LIKE', "%$key%")
                        ->orWhere('phone', 'LIKE', "$key%")
                        ->orWhere('email', 'LIKE', "$key%");
                });
        }
        if ($blacklist) {
            $sql = $sql->where('userStatus', '=', 'BLOCK');
        }
        return json_encode($sql->get()->fetchAll(PDO::FETCH_ASSOC));
    }

}
