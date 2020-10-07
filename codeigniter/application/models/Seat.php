<?php

namespace app\model;

/**
 * Class Seat
 */
class Seat extends MasterOrder
{
    const TABLE_NAME = 'seat';

    const ID = 'id';
    const M_STORE_ID = 'm_store_id';
    const M_SEAT_ID = 'm_seat_id';
    const SEAT_GROUP_ID = 'seat_group_id';
    const UPDATE_TIME = 'update_time';
    const CREATE_TIME = 'create_time';
    const DELETE_TIME = 'delete_time';
    /**
     * @var array カラムリスト
     */
    const DEFAULT_COLUMN_LIST = [
        self::ID,
        self::M_STORE_ID,
        self::M_SEAT_ID,
        self::SEAT_GROUP_ID,
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
