<?php
/**
 * Filename: OrderRepositoryTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{

    private $repository;

    protected function setUp()
    {
        $this->repository = new OrderRepositoryFake();
    }

    public function testCanAddOrder()
    {
        $this->repository->addOrder(new Order(new Customer()));
        $this->assertTrue(true);
    }


    public function testOrderNumberCantBeZeroAfterReconstitution()
    {
        $theOrderNumber = 42;
        $this->fakeAnOrder($theOrderNumber, new Customer());

        $order = $this->repository->getOrder($theOrderNumber);

        $this->assertNotEquals(0, $order->getOrderNumber());
    }

    private function fakeAnOrder($theOrderNumber, $customer)
    {
        $order = new Order($customer);
        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($order, 'orderNumber', $theOrderNumber);
        $this->repository->addOrder($order);
    }

    public function testCanFindOrdersViaCustomer()
    {
        $customer = $this->fakeACustomer(7);

        $this->fakeAnOrder(42, $customer);
        $this->fakeAnOrder(12, $this->fakeACustomer(1));
        $this->fakeAnOrder(3, $customer);
        $this->fakeAnOrder(21, $customer);
        $this->fakeAnOrder(1, $this->fakeACustomer(2));

        $this->assertEquals(3, count($this->repository->getOrders($customer)));
    }

    private function fakeACustomer($customerNumber)
    {
        $customer = new Customer();

        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($customer, 'customerNumber', $customerNumber);

        return $customer;
    }

}