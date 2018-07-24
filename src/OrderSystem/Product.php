<?php
/**
 * Filename: Product.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class Product
{
    private $description;
    private $unitPrice;

    public function __construct($description, $unitPrice)
    {
        $this->description = $description;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return double
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

}