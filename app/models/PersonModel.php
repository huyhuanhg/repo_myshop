<?php


use app\core\Model as DB;

class PersonModel extends DB
{
    const __TABLE__ = 'person';

    public function getAll()
    {
        $data = DB::table('person')->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function checkQuery()
    {
        return DB::table('person')->where('gender', '=', 0)->get();
    }

    public function add($data)
    {
        return DB::table(self::__TABLE__)->insert($data);

    }

    public function getPersonByID($id)
    {
        $data = DB::table(self::__TABLE__)->where('person_ID', '=', $id)->limit(1)->get();
        return json_encode($this->fetchAssoc($data));
    }

    public function delete($id)
    {
        return DB::table(self::__TABLE__)->where('person_ID', '=', $id)->delete();
    }

    public function edit($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return DB::table(self::__TABLE__)->where('person_ID', '=', $id)->update($data);
    }
    public function getByEmail($email){
        return DB::table(self::__TABLE__)->where('email', '=', $email)->get();
    }
}
