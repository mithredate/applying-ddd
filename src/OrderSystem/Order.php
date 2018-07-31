<?php
/**
 * Filename: Order.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;



abstract class Order
{
    const NEW = 0;
    const ORDERED = 1;
    const INVALID = -1;

    abstract public function getOrderNumber();

    abstract public function orderNow();

    abstract public function getCustomerSnapshot();

    abstract public function getCustomerMaxAmountOfDebt();

    abstract public function getStatus();

    abstract public function getOrderDate();

    abstract public function addOrderLine($orderLine);
}