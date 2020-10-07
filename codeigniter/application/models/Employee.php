<?php

namespace app\model;

use app\libraries\CommonTrait;

/**
 * 社員管理用モデル
 * Class Employee
 * @package app\model
 */
class Employee extends MasterAttend
{
    use CommonTrait;

    const TABLE_NAME = 'employee';
    //データID
    const ID = 'id';
    //社員ID
    const EMP_ID = 'emp_id';
    //名前
    const NAME = 'name';
    //誕生日
    const BIRTH_DAY = 'birthday';


    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * employeeテーブルへのデータ追加sql作成
     * @param $insertList
     * @return string
     */
    public function makeSqlInsertByEmployeeTable($insertList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($insertList);

        $sql = self::INSERT_INTO . self::STR_SPACE . self::TABLE_NAME
            . '(' . self::NAME . self::COMMA . self::BIRTH_DAY . ')'
            . self::STR_SPACE . self::VALUES . '(' . $valueList['name'] . self::COMMA . $valueList['birthday'] . ')';

        return $sql;
    }

    /**
     * del_stateでデータ検索sqlの作成
     * @param $searchList
     * @return string
     *
     */
    public function makeSqlGetByDelState($searchList)
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);
        $sql = self::SELECT_FROM
            . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::DEL_STATE . self::EQUAL . $valueList['del_state'];
        return $sql;
    }

    /**
     * del_state更新sql
     * @param $updateList
     * @return string
     *
     */
    public function makeSqlUpdateDelState($updateList)
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($updateList);
        /*
         UPDATE punch
         SET    del_state = ''
         WHERE emp_id = $emp_id
        */
        $sql = self::UPDATE . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::SET
            . self::STR_SPACE . self::DEL_STATE . self::EQUAL . $valueList['del_state']
            . self::STR_SPACE . self::COMMA . self::DELETE_TIME . self::EQUAL . $valueList['delete_time']
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::EMP_ID . self::EQUAL . $valueList['emp_id'];
        return $sql;
    }
}