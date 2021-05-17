<?php

namespace app\core;
use app\Exceptions\AppException as E;
use PDO;
class Database
{
    private $__conn;
    use QueryBuilder;

    public function __construct($table = null)
    {
        $this->__conn = Connect::getInstance(Registry::getIntance()->database)->connect;
        if (isset($table)){
            $this->from = $table;
        }
    }


    public function query($sql)
    {
        try {
            $stmt = $this->__conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        } catch (\PDOException $e) {
            $data['mess'] = $e->getMessage();
            E::loadError('database', $data);
        }
    }
    public function fetchAssoc($data){
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

}
