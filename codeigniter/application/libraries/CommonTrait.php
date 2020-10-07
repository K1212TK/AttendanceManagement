<?php

namespace app\libraries;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use function base_url;
use function redirect;

trait CommonTrait
{

    /**
     * 連想配列へ変換
     * @param array $columnArray
     * @param array $paramArray
     * @return array
     */
    public function toList(array $columnArray, array $paramArray): array
    {
        $insertData = [];
        //連想配列の作成
        foreach ($columnArray as $key => $column) {
            $insertData[$column] = $paramArray[$key];
        }
        return $insertData;
    }

    /**
     * 配列へ変換
     * @param mixed ...$params
     * @return array
     */
    public function toArray(...$params): array
    {
        //格納用配列
        $result = array();
        foreach ($params as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    /**
     * 月初の取得
     * @return false|string
     */
    public function firstMonth()
    {
        // 現在月月初日
        return date("Y-m-01");
    }

    /**
     * 月末の取得
     * @return false|string
     */
    public function lastMonth()
    {
        //現在今月末日
        return date("Y-m-t");
    }

    /**
     * 現在日付の取得
     * @return false|string
     */
    public function nowTime()
    {
        //現在日付
        return date("Y-m-d H:i:s");
    }

    /**
     * 取得した連想配列のそれぞれの値にシングルクォーテーションを付ける
     * @param array $targetList
     * @return array
     */
    public function addQuotation(array $targetList): array
    {
        $resultList = [];
        foreach ($targetList as $key => $target){
            //nullであった場合文字列のnullをセット
            if(is_null($target)){
                $resultList[$key] ='NULL';
                //文字列の場合
            } elseif(is_string($target)){
                $resultList[$key] = '\''.$target.'\'';
            }else{
                $resultList[$key] = $target;
            }
        }
        return $resultList;
    }

    /**
     * 指定したページへリダイレクト
     * @param string $controllerName コントローラ名
     * @param string $functionName ファンクション名
     */
    public function redirect(string $controllerName, string $functionName)
    {
        //Xampp
        //redirect("http://localhost/codeigniter/{$controllerName}/{$functionName}");
        redirect(base_url()."{$controllerName}/{$functionName}");
    }
}
