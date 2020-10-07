<?php
/**
 * Created by PhpStorm.
 * User: k.ogura
 * Date: 2019/12/08
 * Time: 20:04
 */

use app\model\Product;
use app\model\Seat;

/**
 * 注文系 API
 * Class Order
 */
class Order extends MY_Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 注文とる際のトップページAPI
     */
    public function index()
    {
        //modelロード
        $masterModelProduct = new Product();
        $masterModelSeat = new Seat();
        //Logicロード
        $logicOrder = new app\libraries\logic\Order();
        //データ取得
        $masterProductList = $masterModelProduct->getAll();
        $masterSeatList = $masterModelSeat->getAll();
        //レスポンス作成
        $resOrderIndex = $logicOrder->getResponseOrderIndex($masterProductList, $masterSeatList);
        //Response返却
        $this->returnResponse(
            $resOrderIndex->getResponse()
        );
    }
}