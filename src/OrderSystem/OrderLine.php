<?php
/**
 * Filename: OrderLine.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class OrderLine
{
    private $product;
    private $numberOfUnits;
    private $price;

    public function __construct($product)
    {
        $this->product = $product;
        $this->price = $product->getUnitPrice();
    }

    public function setNumberOfUnits($count)
    {
        $this->numberOfUnits = $count;
    }

    public function getPrice()
    {
        return $this->price;
    }

}