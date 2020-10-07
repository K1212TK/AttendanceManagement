<?php


namespace app\libraries\logic;

use app\libraries\response\OrderIndex;
use app\libraries\response\OrderInfo;
use app\libraries\response\Product;

/**
 * 注文管理 オーダー情報　ロジック
 * Class order
 * @package app\libraries\logic
 */
class Order extends LogicBase
{
    /**
     * order/index のレスポンスを作成、返却
     * @param $masterProductList
     * @param $masterSeatList
     * @return OrderIndex
     */
    public function getResponseOrderIndex($masterProductList,$masterSeatList){
        $productList = [];
        $orderInfoList = [];
        foreach ($masterSeatList as $masterSeat) {
            $orderInfo = new OrderInfo();
            $seatId = (int)$masterSeat['m_seat_id'];
            $orderInfo->setSeatNum($seatId);
            foreach ($masterProductList as $masterProduct) {
                $product = new Product();
                $product->setProductId($masterProduct['id']);
                $product->setCategory($masterProduct['category']);
                $product->setName($masterProduct['name']);
                $productList[] = $product;
            }
            $orderInfo->setProductList($productList);
            $orderInfoList[] = $orderInfo;
        }
        $resOrderIndex = new OrderIndex();
        $resOrderIndex->setOrderInfoList($orderInfoList);
        return $resOrderIndex;
    }
}