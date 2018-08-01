<?php
/**
 * Filename: NoOrder.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Customer\CustomerSnapshot;

class NoOrder implements Order
{

    public function getOrderNumber()
    {
        return null;
    }

    public function orderNow()
    {
        throw new ApplicationException("Non-existing order can't be ordered.");
    }

    public function getCustomerSnapshot()
    {
        return new CustomerSnapshot("Nonexistant customer", 0, 0);
    }

    public function getCustomerMaxAmountOfDebt()
    {
        return 0;
    }

    public function getStatus()
    {
        return OrderStatus::INVALID;
    }

    public function getOrderDate()
    {
        return new \DateTime();
    }

    public function addOrderLine($orderLine)
    {
        throw new ApplicationException("Can't add order line to an invalid order!");
    }

    public function accept()
    {
        throw new \BadMethodCallException("Can't accept a non-existing order.");
    }
}