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
}