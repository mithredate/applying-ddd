<?php
/**
 * Filename: OrderRepositoryTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Customer\Customer;
use Mithredate\DDD\Misc\ApplicationException;
use Mithredate\DDD\Misc\RepositoryHelper;
use Mithredate\DDD\Persistence\Workspace;
use Mithredate\DDD\Persistence\WorkspaceFake;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{

    private $repository;
    private $ws;
    private $repositoryHelper;

    protected function setUp()
    {
        $this->ws = new WorkspaceFake(Order::class, "getOrderNumber");
        $this->repository = new OrderRepository($this->ws);
        $this->repositoryHelper = new RepositoryHelper();
    }

    public function testCanAddOrder()
    {
        $this->repository->add(new RealOrder(new Customer()));
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
        $this->repository->add($this->repositoryHelper->fakeAnOrder($theOrderNumber, $customer));
    }

    public function testCanFindOrdersViaCustomer()
    {
        $customer = $this->fakeACustomer(7);

        $this->fakeAnOrder(42, $customer);
        $this->fakeAnOrder(12, $this->fakeACustomer(1));
        $this->fakeAnOrder(3, $customer);
        $this->fakeAnOrder(21, $customer);
        $this->fakeAnOrder(1, $this->fakeACustomer(2));


        $this->assertEquals(3, count($this->repository->getOrdersByCustomer($customer)));
    }

    private function fakeACustomer($customerNumber)
    {
        return $this->repositoryHelper->fakeACustomer($customerNumber);
    }

    public function testReturnNoOrderInsteadOfNull()
    {
        $nullOrder = $this->repository->getOrder(11);

        $this->assertInstanceOf(Order::class, $nullOrder);
    }

    public function testNoOrderHasNullOrderNumber()
    {
        $noOrder = $this->repository->getOrder(13);

        $this->assertNull($noOrder->getOrderNumber());
    }

    public function testOrderIsAddedToWorkspace()
    {
        $countBefore = $this->ws->getCount();

        $this->fakeAnOrder(11, $this->fakeACustomer(22));

        $this->assertEquals($countBefore + 1, $this->ws->getCount());

    }

    public function testOrderIsFetchedFromWorkspace()
    {
        $order = new RealOrder(new Customer());
        $wsMock = \Mockery::mock(Workspace::class);
        $wsMock->shouldReceive("getById")
               ->once()
               ->withArgs([Order::class, 10])
                ->andReturn($order);

        $repository = new OrderRepository($wsMock);
        $fetchedOrder = $repository->getOrder(10);
        $this->assertEquals($order, $fetchedOrder);
    }

    public function testTowRepositoryInstancesKnowTheSameOrder()
    {
        $repository1 = new OrderRepository($this->ws);
        $order = $this->repositoryHelper->fakeAnOrder(37, new Customer());
        $repository1->add($order);

        $this->ws->persistAll();

        $repository2 = new OrderRepository($this->ws);
        $retrievedOrder = $repository2->getOrder(37);

        $this->assertNotNull($retrievedOrder->getOrderNumber());
    }

    public function testNoOrderHasInvalidStatus()
    {
        $order = $this->repository->getOrder(1);
        $this->assertEquals(OrderStatus::INVALID, $order->getStatus());
    }

    public function testNoOrderCantChangeStatusToOrdered()
    {
        $order = $this->repository->getOrder(1);

        $this->expectException(ApplicationException::class);

        $order->orderNow();
    }

    public function testNoOrderCantHaveOrderLines()
    {
        $order = $this->repository->getOrder(1);

        $orderLine = new OrderLine(new Product("Chair", 11));
        $orderLine->setNumberOfUnits(1);

        $this->expectException(ApplicationException::class);

        $order->addOrderLine($orderLine);
    }

}