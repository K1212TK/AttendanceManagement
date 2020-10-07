<?php
/**
 * Created by PhpStorm.
 * User: k.ogura
 * Date: 2019/12/24
 * Time: 0:25
 */

namespace app\libraries\response;

/**
 * Class OrderInfo
 * @package app\libraries\response
 */
class OrderInfo
{
    /* @var int $seatNum */
    protected $seatNum;
    /* @var Product[] $productList */
    protected $productList;

    /**
     * @param int $seatNum
     */
    public function setSeatNum(int $seatNum)
    {
        $this->seatNum = $seatNum;
    }

    /**
     * @param Product[] $productList
     */
    public function setProductList(array $productList)
    {
        $this->productList = $productList;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        $productList = array();
        foreach ($this->productList as $product) {
            $productList[] = $product->getResponse();
        }
        return [
            'seat_num' => $this->seatNum,
            'product_list' => $productList,
        ];
    }
}