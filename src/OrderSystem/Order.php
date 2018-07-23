<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;

class Order
{
    private $customer;
    private $orderDate;

    public function __construct($customer) {
        $this->customer = $customer;
        $this->orderDate = new DateTime('now');
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }
}