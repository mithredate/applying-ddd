<?php
/**
 * Filename: OrderLineTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use PHPUnit\Framework\TestCase;

class OrderLineTest extends TestCase
{
    public function testOrderLineGetsDefaultPrice()
    {
        $product = new Product("Chair", 52.00);

        $orderLine = new OrderLine($product);

        $this->assertEquals(52.00, $orderLine->getPrice());
    }

    public function testOrderLineHasTotalAmount()
    {
        $orderLine = new OrderLine(new Product("Chair", 52.00));
        $orderLine->setNumberOfUnits(2);

        $this->assertEquals(104.00, $orderLine->getTotalAmount());
    }
}