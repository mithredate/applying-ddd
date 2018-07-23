<?php
/**
 * Filename: OrderTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCanCreateOrder()
    {
        $order = new Order(new Customer());

        $this->assertNotNull($order, "Order created from the factory can't be null!");
    }

    public function testCanCreateOrderWithCustomer()
    {
        $order = new Order(new Customer());

        $this->assertNotNull($order->getCustomer(), "Order should have a customer.");
    }

    public function testOrderDateIsCurrentAfterCreation()
    {
        $beforeCreation = new DateTime('now');

        $order = new Order(new Customer());

        $this->assertTrue($order->getOrderDate() > $beforeCreation, "Order date should is invalid!");
        $this->assertTrue($order->getOrderDate() < new DateTime('now'), "Order date should is invalid!");
    }
}