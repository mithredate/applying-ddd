<?php
/**
 * Filename: OrderTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCanCreateOrder()
    {
        $order = new Order(new Customer());

        $this->assertNotNull($order, "Order created from the factory can't be null!");
    }
}