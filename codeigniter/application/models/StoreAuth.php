<?php


namespace app\model;


use app\libraries\CommonTrait;
use function var_dump;

class StoreAuth extends MasterStore
{
    use CommonTrait;

    const TABLE_NAME = 'store_auth';
    const STORE_ID = 'store_id';
    const NAME = 'name';
    const PASSWORD ='password';

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * ユーザー名、パスワードが一致するデータの取得
     * @param $searchList
     */
    public function makeSqlGetByUserNameAndPassword($searchList){
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);

        $sql = self::SELECT_FROM
            .self::STR_SPACE.self::TABLE_NAME
            .self::STR_SPACE.self::WHERE
            .self::STR_SPACE.self::NAME.self::EQUAL.$valueList['name']
            .self::STR_SPACE.self::AND
            .self::STR_SPACE.self::PASSWORD.self::EQUAL.$valueList['password'];

        return $sql;
    }

}