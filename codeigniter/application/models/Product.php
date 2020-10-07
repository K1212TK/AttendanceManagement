<?php

namespace app\model;

/**
 * Class Product
 */
class Product extends MasterOrder
{
    const TABLE_NAME = 'product';

    const ID = 'id';
    const CATEGORY = 'category';
    const NAME = 'name';
    const UPDATE_TIME = 'update_time';
    const CREATE_TIME = 'create_time';
    const DELETE_TIME = 'delete_time';
    /**
     * @var array カラムリスト
     */
    const DEFAULT_COLUMN_LIST = [
        self::ID,
        self::CATEGORY,
        self::NAME,
    ];
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = self::TABLE_NAME;
        $this->primaryKey = self::ID;
    }
}
