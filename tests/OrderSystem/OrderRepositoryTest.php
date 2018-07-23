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
        $this->fakeAnOrder($theOrderNumber);

        $order = $this->repository->getOrder($theOrderNumber);

        $this->assertNotEquals(0, $order->getOrderNumber());
    }

    private function fakeAnOrder($theOrderNumber)
    {
        $order = new Order(new Customer());
        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($order, 'orderNumber', $theOrderNumber);
        $this->repository->addOrder($order);
    }

}