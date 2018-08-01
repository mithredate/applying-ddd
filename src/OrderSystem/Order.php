<?php
/**
 * Filename: Order.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;



use Mithredate\DDD\Persistence\ValidatableRegardingPersistence;

interface Order extends ValidatableRegardingPersistence
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