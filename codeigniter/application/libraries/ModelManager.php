<?php


namespace app\libraries;

use app\model\MasterAttend;
use app\model\UserAttend;

/**
 * Class ModelManager
 * @package app\libraries
 */
class ModelManager
{
    private static $modelManager;
    private $sqlList;

    private function __construct()
    {
        $this->sqlList = [];
    }

    /**
     * インスタンス取得
     * @return ModelManager
     */
    public static function getInstance()
    {
        if (!isset(self::$modelManager)) {

            self::$modelManager = new ModelManager();

        }

        return self::$modelManager;
    }

    /**
     * 取得したsqlをため込む
     * @param $sql
     * @param $dbName
     */
    public function sqlStorage($sql,$dbName)
    {
        $this->sqlList[$dbName][] = $sql;
    }

    /**
     * 更新処理の実行
     */
    public function execStorage(){

        $userAttend = new UserAttend();
        $masterAttend = new MasterAttend();
        foreach ($this->sqlList as $key => $sqlList){
            foreach ($sqlList as $sql){
                switch ($key) {
                    case $userAttend::DB_NAME:
                        $userAttend->execInsertUpdate($sql);
                        break;
                    case $masterAttend::DB_NAME:
                        $masterAttend->execInsertUpdate($sql);
                        break;
                    default:
                        break;
                }
            }
        }
    }
}
