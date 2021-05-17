<?php

namespace app\core;
use app\Exceptions\AppException as E;
use \PDO;
use PDOException;
class Connect
{
    private static $instance = null;
    public $connect = null;

    private function __construct($db)
    {
        try{
            //cau hinh dsn
            $dsn = "mysql:dbname=".$db['dbName'].";host=".$db['host'];
            //cau hinh options
            /**
             * - utf8
             * ngoai le truy van loi
             */
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            //lenh ket noi
            $this->connect = new PDO($dsn, $db['user'], $db['password'], $options);
        } catch (PDOException $e){
            $data['mess'] = $e->getMessage();
            E::loadError('database', $data);
        }


    }

    public static function getInstance($db)
    {
        if (self::$instance === null) {
            self::$instance = new self($db);
        }
        return self::$instance;
    }
}
