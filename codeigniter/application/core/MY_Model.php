<?php

use app\libraries\CommonTrait;

/**
 * MY_Model
 * コントローラーのベースクラス
 * 基本的にはコントローラはこれを継承して実装していく
 *
 */
class MY_Model extends CI_Model
{
    use CommonTrait;

    protected $tableName = "";
    protected $primaryKey = "";
    protected $config = [];
    //select
    const SELECT_FROM = 'SELECT * FROM';
    const WHERE = 'WHERE';
    const AND = 'AND';
    const STR_SPACE = ' ';
    const OPERAND_OVER_EQUAL = '>=';
    const OPERAND_LOW_EQUAL = '<=';
    const EQUAL = '=';
    const UPDATE = 'UPDATE';
    const SET = 'SET';
    const COMMA = ',';
    const INSERT_INTO = 'INSERT INTO';
    const VALUES = 'VALUES';
    const ORDER_BY = 'ORDER BY';
    const LIMIT = 'LIMIT';
    const DESC = 'DESC';
    const SELECT = 'SELECT';
    const FROM = 'FROM';
    const MAX = 'MAX';
    const MIN = 'MIN';
    const AS = 'AS';
    const BETWEEN = 'BETWEEN';
    //共通カラム
    const DEL_STATE = 'del_state';
    const DELETE_TIME = 'delete_time';
    const DEL_STATE_ON = '1';
    const DEL_STATE_OFF = '0';

    /**
     * @return string
     * テーブル名取得
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * DB設定コンフィグセット
     * @param string $databaseName
     */
    protected function setDBConfig(string $databaseName)
    {
        $this->config = [
            'hostname' => 'localhost.localdomain',
            'username' => 'root',
            'password' => '',
            'dbdriver' => 'mysqli',
            'database' => $databaseName,
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => TRUE,
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
        ];
    }

    /**
     * データベース設定読み込み
     */
    protected function loadDatabase()
    {
        //データベースオブジェクトをDBに入れる
        $this->db = $this->load->database($this->config, true);
    }

    /**
     * MY_Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * select文の実行
     * @param $sql
     * @return array
     */
    public function execSelect($sql)
    {

        return $this->db->query($sql)->result_array();
    }

    /**
     * 検索レコードを一件取得
     * @param string $sql
     */
    public function execRowSelect(string $sql){

        return $this->db->query($sql)->row_array();
    }

    /**
     * 更新、挿入sqlの実行
     * @param $sql
     */
    public function execInsertUpdate($sql)
    {
        $this->db->query($sql);
    }


    /**
     * テーブルデータ全取得
     * @return array
     */
    function execAllSelect()
    {
        $sql = self::SELECT_FROM . self::STR_SPACE . $this->tableName;
        /*** @var CI_DB_result $query */
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 対象カラムの最大値取得
     * @param string $columnName
     * @return array
     */
    public function execMaxSelect(string $columnName): array
    {

        $sql = self::SELECT
            . self::STR_SPACE . self::MAX . '(' . $columnName . ')' . self::STR_SPACE . self::AS . self::STR_SPACE . $columnName
            . self::STR_SPACE . self::FROM
            . self::STR_SPACE . $this->getTableName();
        /*** @var CI_DB_result $query */
        $query = $this->db->query($sql);
        //一行データを返す
        return $query->row_array();
    }

    /**
     * 対象カラムの最小値取得
     * @param string $columnName
     * @return array
     */
    public function execMinSelect(string $columnName): array
    {

        $sql = self::SELECT
            . self::STR_SPACE . self::MIN . '(' . $columnName . ')' . self::STR_SPACE . self::AS . self::STR_SPACE . $columnName
            . self::STR_SPACE . self::FROM
            . self::STR_SPACE . $this->getTableName();
        /*** @var CI_DB_result $query */
        $query = $this->db->query($sql);
        //一行データを返す
        return $query->row_array();
    }

    /**
     * keyでデータを検索しデータを取得する
     * @param $keyList
     * @return mixed
     */
    public function makeSqlSelect($keyList)
    {
        //シングルクォーテーションをつける処理
        $valueList = $this->addQuotation($keyList);

        $selectFrom = self::SELECT_FROM
            . self::STR_SPACE . $this->getTableName()
            . self::STR_SPACE . self::WHERE
            . self::STR_SPACE;
        //格納用変数
        $where = '';
        foreach ($valueList as $key => $value) {
            if (empty($where)) {
                $where = $key . self::EQUAL . $value;
            } else {
                $where .= self::STR_SPACE . self:: AND . self::STR_SPACE . $key . self::EQUAL . $value;
            }
        }
        $sql = $selectFrom . $where;

        return $sql;
    }

}
