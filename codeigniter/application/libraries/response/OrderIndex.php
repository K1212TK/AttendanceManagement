<?php
/**
 * Created by PhpStorm.
 * User: k.ogura
 * Date: 2019/12/24
 * Time: 0:25
 */

namespace app\libraries\response;

/**
 * Class ProductList
 * @package app\libraries
 */
class OrderIndex
{
    /** @var OrderInfo[] */
    protected $orderInfoList;

    /**
     * @param OrderInfo[] $orderInfoList
     */
    public function setOrderInfoList(array $orderInfoList)
    {
        $this->orderInfoList = $orderInfoList;
    }

    public function getResponse()
    {
        $orderInfoList = array();
        foreach ($this->orderInfoList as $orderInfo) {
            $orderInfoList[] = $orderInfo->getResponse();
        }
        return [
            'order_info_list' => $orderInfoList
        ];
    }
}