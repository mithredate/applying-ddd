<?php
/**
 * Filename: ReadyToInvoiceSpecification.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class ReadyToInvoiceSpecification implements Specification
{

    public function test($order)
    {
        if (!$order->isInThisStateOrBeyond(OrderStatus::ACCEPTED)) {
            return false;
        }
    }
}