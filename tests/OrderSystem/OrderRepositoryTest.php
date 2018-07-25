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
        $this->repository->addOrder(new OrderImp(new Customer()));
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
        $order = new OrderImp($customer);
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

    public function testReturnNoOrderInsteadOfNull()
    {
        $nullOrder = $this->repository->getOrder(11);

        $this->assertInstanceOf(Order::class, $nullOrder);
    }

    public function testTowRepositoryInstancesKnowTheSameOrder()
    {
        $this->markTestSkipped();
        $repository1 = new OrderRepositoryFake();
        $order = $this->fakeAnOrder(37, $this->fakeACustomer(2));
        $repository1->addOrder($order);

        $repository2 = new OrderRepositoryFake();
        $retrievedOrder = $repository2->getOrder(37);

        $this->assertNotNull($retrievedOrder->getOrderNumber());
    }

}