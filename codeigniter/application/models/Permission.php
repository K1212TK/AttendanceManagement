<?php


namespace app\model;


use app\libraries\CommonTrait;

class Permission extends MasterAttend
{

    use CommonTrait;

    const TABLE_NAME = 'permission';
    //店舗ID
    const STORE_ID = 'store_id';
    //ユーザー名
    const NAME = 'name';
    //パスワード
    const PASSWORD = 'password';

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = self::TABLE_NAME;
    }

}