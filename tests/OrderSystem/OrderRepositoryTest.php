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
    }


    public function testOrderNumberCantBeZeroAfterReconstitution()
    {
        $this->markTestIncomplete("Order repository has not been implemented yet!");
        $theOrderNumber = 42;
        $this->fakeAnOrder($theOrderNumber);

        $order = $this->repository->getOrder($theOrderNumber);

        $this->assertEquals($theOrderNumber, $order->getOrderNumber());
    }

    private function fakeAnOrder($theOrderNumber)
    {
    }

}