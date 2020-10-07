<?php

use app\libraries\ImageManager;

defined('BASEPATH') OR exit('No direct script access allowed');

class shift extends MY_Controller
{

    /**
     * シフト確認画面を表示する
     */
    public function shift_open()
    {
        //セッションの確認
        $this->checkSessionStoreId();
        //画面表示用画像の取得
        $data['images'] = ImageManager::getInstance()->getImageList();

        //共通読み込み
        $this->load->helper('url');
        $this->load->view("common/loader");
        //viewの生成
        $this->load->view("common/head");
        $this->load->view("common/header",$data);
        $this->load->view("shift_manager");
        $this->load->view("common/circles");
        $this->load->view("common/footer");
    }
}
