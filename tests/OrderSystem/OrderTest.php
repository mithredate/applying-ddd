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
        $order = new RealOrder(new Customer());

        $this->assertNotNull($order, "Order created from the factory can't be null!");
    }

    public function testCanCreateOrderWithCustomer()
    {
        $order = new RealOrder(new Customer());

        $this->assertNotNull($order->getCustomerSnapshot(), "Order should have a customer.");
    }

    public function testOrderDateIsCurrentAfterCreation()
    {
        $beforeCreation = new DateTime('now');

        $order = new RealOrder(new Customer());

        $this->assertTrue($order->getOrderDate() > $beforeCreation, "Order date should is invalid!");
        $this->assertTrue($order->getOrderDate() < new DateTime('now'), "Order date should is invalid!");
    }

    public function testOrderNumberIsZeroAfterCreation()
    {
        $order = new RealOrder(new Customer());

        $this->assertEquals(0, $order->getOrderNumber(), "The order number should be zero after creation.");
    }

    public function testEmptyOrderHasZeroForTotalAmount()
    {
        $order = new RealOrder(new Customer());

        $this->assertEquals(0, $order->getTotalAmount());
    }

    public function testOrderWithLinesHasTotalAmount()
    {
        $order = new RealOrder(new Customer());

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

        $order = new RealOrder($customer);

        $customer->setName("Saab");

        $this->assertEquals("Volvo", $order->getCustomerName());
    }

    public function testNewOrderHasCorrectStatus()
    {
        $order = new RealOrder(new Customer());

        $this->assertEquals(RealOrder::NEW, $order->getStatus());
    }

    public function testValidOrderCanBeOrdered()
    {
        $customer = new Customer();
        $customer->setMaxAmountOfDebt(1000);
        $order = new RealOrder($customer);
        $orderLine = new OrderLine(new Product("Chair", 52.00));
        $orderLine->setNumberOfUnits(12);
        $order->addOrderLine($orderLine);
        $order->orderNow();

        $this->assertEquals(OrderStatus::ORDERED, $order->getStatus());
    }

    public function testCantGoToOrderedStateWithExceededMaxAmount()
    {
        $order = new RealOrder(new Customer());

        $orderLine = new OrderLine(new Product("Chair", 1));
        $orderLine->setNumberOfUnits(2000000);

        $order->addOrderLine($orderLine);

        $this->expectException(ApplicationException::class);

        $order->orderNow();
    }

    public function testCanHaveCustomerDependentMaxDebt()
    {
        $customer = new Customer();
        $customer->setMaxAmountOfDebt(10);

        $order = new RealOrder($customer);

        $orderLine = new OrderLine(new Product("Chair", 11));
        $orderLine->setNumberOfUnits(1);

        $order->addOrderLine($orderLine);

        $this->expectException(ApplicationException::class);

        $order->orderNow();
    }

    public function testCanMakeStateTransitionSafely()
    {
        self::markTestSkipped();
        $order = new RealOrder(new Customer());

        $this->assertEquals(0, count($order->getBrokenRulesIfAccepted()));

        $order->accept();
    }

    public function testCantExceedStringLengthWhenPersisting()
    {
        $order = new RealOrder(new Customer());
        $order->setNote("This is a sample note which is too long to be stored in a database through persistence mechanism!");

        $this->assertFalse($order->isValidRegardingPersistence());
    }

    public function testDifferentIdeasWithTheRulesAPI()
    {
        $order = new RealOrder(new Customer());

        $order->setNote("This is a short note");
        $this->assertTrue($order->isValidRegardingPersistence());
        $this->assertEquals(0, count($order->getBrokenRulesRegardingPersistence()));

        $tomorrow = new DateTime("tomorrow");
        $order->setOrderDate($tomorrow);
        $this->assertFalse($order->isValidRegardingPersistence());
        $this->assertEquals(1, count($order->getBrokenRulesRegardingPersistence()));

        $order->setOrderDate(new DateTime('now -10 seconds'));
        $this->assertTrue($order->isValidRegardingPersistence());
        $this->assertEquals(0, count($order->getBrokenRulesRegardingPersistence()));

        $order->setNote("This is going to make the order invalid regarding persistence!");
        $this->assertFalse($order->isValidRegardingPersistence());
        $this->assertEquals(1, count($order->getBrokenRulesRegardingPersistence()));
    }

    public function testTryingTheAcceptTransitionWithTheRulesAPI()
    {
        $customer = new Customer();
        $order = new RealOrder($customer);

        $this->assertFalse($order->isOKToAccept());
        $customer->accept();
        $this->assertTrue($order->isOKToAccept());

        $order->setOrderDate(new DateTime("tomorrow"));
        $this->assertFalse($order->isOKToAccept());

        $this->expectException(ApplicationException::class);
        $order->accept();
    }
}