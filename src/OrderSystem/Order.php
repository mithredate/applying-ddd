<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class Order
{
    private $customer;

    public function __construct($customer) {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}