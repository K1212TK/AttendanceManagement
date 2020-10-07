<?php

namespace app\model;

use app\libraries\CommonTrait;

/**
 * Class Punch
 * @package app\model
 */
class Punch extends UserAttend
{
    use CommonTrait;

    const TABLE_NAME = 'punch';
    //管理ID
    const ID = 'id';
    //社員ID
    const EMP_ID = 'emp_id';
    //出勤時間
    const PUNCH_IN = 'punch_in';
    //退勤時間
    const PUNCH_OUT = 'punch_out';
    //出退勤ステータス
    const PUNCH_STATE = 'punch_state';
    //修正ステータス
    const FIX_STATE = 'fix_state';

    //退勤ステータス
    const PUNCH_STATE_OUT = '2';
    //変更ステータス
    const FIX_STATE_DONE = '1';




    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
        $this->tableName = self::TABLE_NAME;
    }

    /**
     * 勤務時間検索sqlの作成
     * @param array $searchList
     * @return string
     */
    public function makeSqlGetByPunchInAndPunchState(array $searchList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);
        //SELECT * FROM punch WHERE punch_in >= $firstDate AND  punch_in <= $lastDate AND punch_state = $punchState ;
        $sql = self::SELECT_FROM . self::STR_SPACE . $this->getTableName()
            . self::STR_SPACE . self::WHERE . self::STR_SPACE . self::PUNCH_IN . self::OPERAND_OVER_EQUAL . $valueList['firstDate']
            . self::STR_SPACE . self:: AND . self::STR_SPACE . self::PUNCH_IN . self::OPERAND_LOW_EQUAL . $valueList['lastDate']
            . self::STR_SPACE . self:: AND . self::STR_SPACE . self::PUNCH_STATE . self::EQUAL . $valueList['punch_state'];

        return $sql;
    }

    /**
     * 勤怠データ更新sqlの作成
     * @param array $updateList
     * @return string
     */
    public function makeSqlUpdateByFixStateAndPunch(array $updateList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($updateList);
        /*
        UPDATE punch
        SET
        punch_in = '',
        punch_out  = '',
        punch_state = '',
        fix_state = ''
        WHERE id = ''
        */
        $sql = self::UPDATE . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::SET
            . self::STR_SPACE . self::PUNCH_IN . self::EQUAL . $valueList['punch_in'] . self::COMMA
            . self::STR_SPACE . self::PUNCH_OUT . self::EQUAL . $valueList['punch_out'] . self::COMMA
            . self::STR_SPACE . self::PUNCH_STATE . self::EQUAL . $valueList['punch_state'] . self::COMMA
            . self::STR_SPACE . self::FIX_STATE . self::EQUAL . $valueList['fix_state']
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::ID . self::EQUAL . $valueList['id'];

        return $sql;
    }

    /**
     * 勤怠データの削除フラグ更新sqlの作成
     * @param $updateList
     * @return string
     */
    public function makeSqlUpdateDelState($updateList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($updateList);
        /*
         UPDATE punch
         SET    del_state = ''
         WHERE id = $id
        */
        $sql = self::UPDATE . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::SET
            . self::STR_SPACE . self::DEL_STATE . self::EQUAL . $valueList['del_state']
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::ID . self::EQUAL . $valueList['id'];

        return $sql;
    }

    /**
     * 取得件数を絞りこんで取得
     * @param $searchList
     * @return string
     */
    public function makeSqlGetByPunchStateAndDelStateANDLimit($searchList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);
        /*
         * SELECT * FROM punch WHERE punch_state = '1' AND del_state = '0'
         * ORDER BY emp_id DESC
         * LIMIT 50
         */
        $sql = self::SELECT_FROM . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::PUNCH_STATE . self::EQUAL . $valueList['punch_state']
            . self::STR_SPACE . self:: AND
            . self::STR_SPACE . self::DEL_STATE . self::EQUAL . $valueList['del_state']
            . self::STR_SPACE . self::ORDER_BY
            . self::STR_SPACE . self::EMP_ID . self::STR_SPACE . self::DESC
            . self::STR_SPACE . self::LIMIT
            . self::STR_SPACE . $valueList['limit'];

        return $sql;
    }

    /**
     * 出勤時間を条件にデータ取得
     * @param $searchList
     * @return string
     */
    public function makeSqlGetByPunchIn($searchList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);
        //SELECT * FROM punch WHERE punch_in >= 時間;
        $sql = self::SELECT_FROM . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::PUNCH_IN . self::STR_SPACE . self::BETWEEN
            . self::STR_SPACE . $valueList['start_punch_in']
            . self::STR_SPACE . self::AND
            . self::STR_SPACE .  $valueList['end_punch_in']
            . self::STR_SPACE . self:: AND
            . self::STR_SPACE . self::DEL_STATE . self::EQUAL . $valueList['del_state'];
        return $sql;
    }

    /**
     * 出勤データのインサートsql作成
     * @param $insertList
     * @return string
     */
    public function makeSqlInsertByPunchIn($insertList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($insertList);
        //INSERT INTO punch(emp_id,punch_in,punch_state) VALUES ($insertList['emp_id'],$insertList['punch_in'],$insertList['punch_state']);
        $sql = self::INSERT_INTO . self::STR_SPACE . self::TABLE_NAME
            . '(' . self::EMP_ID . self::COMMA . self::PUNCH_IN . self::COMMA . self::PUNCH_STATE . ')'
            . self::STR_SPACE . self::VALUES
            . self::STR_SPACE . '(' . $valueList['emp_id'] . self::COMMA . $valueList['punch_in'] . self::COMMA . $valueList['punch_state'] . ')';
        return $sql;
    }

    /**
     * idで検索するsqlの作成
     * @param $searchList
     * @return string
     */
    public function makeSqlGetById($searchList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($searchList);
        $sql = self::SELECT_FROM
            . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::ID . self::EQUAL . $valueList['id'];
        return $sql;
    }

    /**
     * 退勤時間更新sql
     * @param $updateList
     * @return string
     */
    public function makeSqlUpdateByPunchOut($updateList): string
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($updateList);
        //UPDATE punch SET punch_out = '', punch_state = '' WHERE id = '';
        $sql = self::UPDATE . self::STR_SPACE . self::TABLE_NAME
            . self::STR_SPACE . self::SET
            . self::STR_SPACE . self::PUNCH_OUT . self::EQUAL . $valueList['punch_out'] . self::COMMA
            . self::PUNCH_STATE . self::EQUAL . $valueList['punch_state']
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE . self::ID . self::EQUAL . $valueList['id'];
        return $sql;
    }
}
