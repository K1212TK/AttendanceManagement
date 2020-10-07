<?php

use app\libraries\ImageManager;
use app\model\StoreAuth;

class general extends MY_Controller{


    public function index()
    {
        //画面表示用画像の取得
        $viewData['images'] = ImageManager::getInstance()->getImageList();
        //共通読み込み
        $this->settingLoad();
        //viewヘッダー読み込み
        $this->headLoad($viewData);
        //bodyの読み込み
        $this->bodyLoad('general/index', $viewData);
        //footerの読み込み
        $this->footerLoad();
    }

    /**
     * ログイン認証を行う
     */
    public function loginAuth()
    {
        //logic読み込み
        $logicGeneral = new \app\libraries\logic\General();
        //model読み込み
        $storeAuth = new StoreAuth();
        //名前
        $name = $this->input->post('name');
        //パスワード
        $password = $this->input->post('password');
        //名前とパスワードが一致するデータの取得
        $authDataList = $logicGeneral->makeAuthUserData($name, $password, $storeAuth);
        //ログイン成功時
        if (!empty($authDataList)) {
            //セッションにログイン情報の追加
            $this->session->set_userdata('store_id',$authDataList['store_id']);
            $logicGeneral->redirect('Attend', 'index');
        } else {
            //失敗した場合ログイン画面に戻す
            $logicGeneral->redirect('general','index');
        }
    }
}


