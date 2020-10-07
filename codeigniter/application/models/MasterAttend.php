<?php

namespace app\model;

use MY_Model;

/**
 * db_hachimaro_attend_master用親クラス
 * Class MY_MasterAttend
 */
class MasterAttend extends MY_Model
{
    const DB_NAME = 'db_hachimaro_attend_master';

    public function __construct()
    {
        parent::__construct();
        $this->setDBConfig('db_hachimaro_attend_master');
        $this->loadDatabase();
    }
}