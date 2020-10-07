<?php

namespace  app\model;

use MY_Model;
/**
 * db_hachimaro_order_master 用親クラス
 * Class MasterOrder
 */
class MasterOrder extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setDBConfig('db_hachimaro_order_master');
        $this->loadDatabase();
    }
}