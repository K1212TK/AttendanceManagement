<?php

namespace  app\model;

use MY_Model;

/**
 * Class UserAttend
 * @package app\model
 */
class UserAttend extends MY_Model
{
    const DB_NAME = 'db_hachimaro_attend_user';

    public function __construct()
    {
        parent::__construct();
        $this->setDBConfig('db_hachimaro_attend_user');
        $this->loadDatabase();
    }
}
