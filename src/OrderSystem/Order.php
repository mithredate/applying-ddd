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
    private $orderNumber;

    public function __construct($customer) {
        $this->customer = $customer;
        $this->orderDate = new DateTime('now');
        $this->orderNumber = 0;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }
}