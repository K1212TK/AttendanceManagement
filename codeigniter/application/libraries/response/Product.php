<?php
/**
 * Created by PhpStorm.
 * User: k.ogura
 * Date: 2019/12/24
 * Time: 0:25
 */

namespace app\libraries\response;

/**
 * Class Product
 * @package app\libraries
 */
class Product
{
    /* @var int $productId */
    protected $productId;
    /* @var int $category */
    protected $category;
    /* @var string $name */
    protected $name;

    /**
     * @param int $productId
     */
    public function setProductId(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category)
    {
        $this->category = $category;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return [
            'id' => $this->productId,
            'category' => $this->category,
            'name' => $this->name,
        ];
    }
}