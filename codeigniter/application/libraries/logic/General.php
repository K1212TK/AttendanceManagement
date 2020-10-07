<?php


namespace app\libraries\logic;


use app\model\StoreAuth;

class General extends LogicBase
{
    /**
     * ユーザー、パスワードの認証データの取得
     * @param string $name
     * @param string $password
     * @param StoreAuth $storeAuth
     * @return array
     */
    public function makeAuthUserData(string $name, string $password, StoreAuth $storeAuth): array
    {
        $searchList = [
            'name' => $name,
            'password' => $password,
        ];
        //ユーザー名、パスワード確認用sqlの作成
        $sql = $storeAuth->makeSqlGetByUserNameAndPassword($searchList);
        $authDataList = $storeAuth->execRowSelect($sql);

        return $authDataList;
    }


}