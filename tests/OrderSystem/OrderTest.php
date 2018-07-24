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

    public function testOrderNumberIsZeroAfterCreation()
    {
        $order = new Order(new Customer());

        $this->assertEquals(0, $order->getOrderNumber(), "The order number should be zero after creation.");
    }

    public function testEmptyOrderHasZeroForTotalAmount()
    {
        $order = new Order(new Customer());

        $this->assertEquals(0, $order->getTotalAmount());
    }

//    public function testOrderWithLinesHasTotalAmount()
//    {
//        $order = new Order(new Customer());
//
//        $orderLine = new OrderLine(new Product("Chair", 52.00));
//        $orderLine->setNumberOfUnits(2);
//
//        $order->addOrderLine($orderLine);
//
//        $this->assertEquals(104.00, $order->getTotalAmount());
//    }
}