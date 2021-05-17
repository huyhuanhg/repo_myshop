<?php

use app\core\Model as DB;

class UserModel extends DB
{
    const __TABLE__ = 'users';

    public function get()
    {
    }

    public function getAll()
    {
        $data = DB::table('person')->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function getById($id)
    {
        return DB::table(self::__TABLE__)->where('account', '=', $id)->get();
    }

    public function user_exists($userInfo)
    {
        $user = DB::table(self::__TABLE__)->where('account', '=', $userInfo['acc'])->get();
        $user = $this->fetchAssoc($user);
        if (count($user) === 1) {
            $user = reset($user);
            if (password_verify($userInfo['pass'], $user['password'])){
                return $user;
            }
        }
        return false;
    }

    public function registry($data)
    {
        return DB::table(self::__TABLE__)->insert($data);
    }
}
