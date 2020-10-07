<?php

use app\libraries\CommonTrait;

/**
 * Class MY_Controller
 * @property  CI_Input input
 */
class MY_Controller extends CI_Controller
{

    use CommonTrait;
    /**
     * 返却用情報をJsonにして返却する
     * @param $resultParam
     */
    public function returnResponse($resultParam)
    {
        // JSON用のヘッダを定義して出力
        $resultJson = json_encode($resultParam);
        header("Content-Type: text/javascript; charset=utf-8");
        echo $resultJson;
        exit();
    }

    /**
     * 共通読み込み処理
     */
    public function settingLoad(){
        //j-query読み込み
        $this->load->view("common/loader");
    }

    /**
     * 共通のヘッダー読み込み処理
     * @param $dataList
     */
    public function headLoad($dataList){
        //viewの生成
        $this->load->view("common/head");
        $this->load->view("common/header",$dataList);
    }

    /**
     * body読み込み
     * @param $viewName
     * @param array $dataList
     */
    public function bodyLoad($viewName,array $dataList =[]){

        $this->load->view($viewName, $dataList);
    }

    /**
     * 共通のfooterの読み込み
     */
    public function footerLoad(){
        $this->load->view("common/circles");
        $this->load->view("common/footer");
    }

    /**
     * セッションを破棄する
     * @param array $keyList
     */
    protected function cleanSession(array $keyList){
        //指定したkeyセッションの破棄
        $this->session->unset_userdata($keyList);
    }

    /**
     * 店舗のセッションが切れていないかを確認する
     */
    protected  function checkSessionStoreId(){
        //セッションが破棄されていないかの確認
        if(!isset($_SESSION['store_id'])){
            $this->redirect('general','index');
        }
    }
}
