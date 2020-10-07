<?php


namespace app\model;


use MY_Model;

class MasterStore extends MY_Model
{
    const DB_NAME = 'db_store_master';

    public function __construct()
    {
        parent::__construct();
        $this->setDBConfig(self::DB_NAME);
        $this->loadDatabase();
    }
}