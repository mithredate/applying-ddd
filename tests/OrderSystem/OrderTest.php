<?php
/**
 * Filename: OrderTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;
use Mithredate\DDD\Customer\Customer;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testCanCreateOrder()
    {
        $order = new OrderImp(new Customer());

        $this->assertNotNull($order, "Order created from the factory can't be null!");
    }

    public function testCanCreateOrderWithCustomer()
    {
        $order = new OrderImp(new Customer());

        $this->assertNotNull($order->getCustomerSnapshot(), "Order should have a customer.");
    }

    public function testOrderDateIsCurrentAfterCreation()
    {
        $beforeCreation = new DateTime('now');

        $order = new OrderImp(new Customer());

        $this->assertTrue($order->getOrderDate() > $beforeCreation, "Order date should is invalid!");
        $this->assertTrue($order->getOrderDate() < new DateTime('now'), "Order date should is invalid!");
    }

    public function testOrderNumberIsZeroAfterCreation()
    {
        $order = new OrderImp(new Customer());

        $this->assertEquals(0, $order->getOrderNumber(), "The order number should be zero after creation.");
    }

    public function testEmptyOrderHasZeroForTotalAmount()
    {
        $order = new OrderImp(new Customer());

        $this->assertEquals(0, $order->getTotalAmount());
    }

    public function testOrderWithLinesHasTotalAmount()
    {
        $order = new OrderImp(new Customer());

        $orderLine = new OrderLine(new Product("Chair", 52.00));
        $orderLine->setNumberOfUnits(2);

        $secondOrderLine = new OrderLine(new Product("Desk", 115.00));
        $secondOrderLine->setNumberOfUnits(3);

        $order->addOrderLine($orderLine);
        $order->addOrderLine($secondOrderLine);

        $this->assertEquals(104.00 + 345.00, $order->getTotalAmount());
    }

    public function testOrderHasSnapshotOfRealCustomer()
    {
        $customer = new Customer();
        $customer->setName("Volvo");

        $order = new OrderImp($customer);

        $customer->setName("Saab");

        $this->assertEquals("Volvo", $order->getCustomerName());
    }

    public function testNewOrderHasCorrectStatus()
    {
        $order = new OrderImp(new Customer());

        $this->assertEquals(OrderImp::NEW, $order->getStatus());
    }

    public function testOrderTransitionsToOrdered()
    {
        self::markTestSkipped();
        $order = new OrderImp(new Customer());
        $orderLine = new OrderLine(new Product("Chair", 52.00));
        $orderLine->setNumberOfUnits(12);
        $order->addOrderLine($orderLine);
        $order->orderNow();

        $this->assertEquals(OrderImp::ORDERED, $order->getStatus());
    }

    public function testCantGoToOrderedStateWithExceededMaxAmount()
    {
        $this->markTestSkipped();
        $order = new OrderImp(new Customer());

        $orderLine = new OrderLine(new Product("Chair", 1));
        $orderLine->setNumberOfUnits(2000000);

        $order->addOrderLine($orderLine);

        $this->expectException(ApplicationException::class);

        $order->orderNow();
    }
}