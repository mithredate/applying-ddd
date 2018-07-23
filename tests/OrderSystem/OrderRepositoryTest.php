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
        $this->repository = new OrderRepository();
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
        $customer = new Customer();

        $this->markTestSkipped();

        $this->fakeAnOrder(42, $customer);
    }

}