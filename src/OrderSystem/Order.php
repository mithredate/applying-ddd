<?php
/**
 * Filename: Order.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;



interface Order
{

    public function getOrderNumber();

    public function orderNow();

    public function getCustomerSnapshot();

    public function getCustomerMaxAmountOfDebt();

    public function getStatus();

    public function getOrderDate();

    public function addOrderLine($orderLine);

    public function accept();
}