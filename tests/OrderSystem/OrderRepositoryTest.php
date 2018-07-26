<?php
/**
 * Filename: OrderRepositoryTest.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Customer\Customer;
use Mithredate\DDD\Misc\RepositoryHelper;
use Mithredate\DDD\Persistence\WorkspaceFake;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{

    private $repository;
    private $ws;

    protected function setUp()
    {
        $this->ws = new WorkspaceFake(Order::class, "getOrderNumber");
        $this->repository = new OrderRepositoryFake($this->ws);
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
        $order = new OrderImp(new Customer());
        $wsMock = \Mockery::mock(Workspace::class);
        $wsMock->shouldReceive("getById")
               ->once()
               ->withArgs([Order::class, 10])
                ->andReturn($order);

        $repository = new OrderRepositoryFake($wsMock);
        $fetchedOrder = $repository->getOrder(10);
        $this->assertEquals($order, $fetchedOrder);
    }

    public function testTowRepositoryInstancesKnowTheSameOrder()
    {
        self::markTestSkipped();
        $repository1 = new OrderRepositoryFake($this->ws);
        $order = new OrderImp($this->fakeACustomer(2));
        $repository1->addOrder($order);

        $this->ws->persistAll();

        $repository2 = new OrderRepositoryFake($this->ws);
        $retrievedOrder = $repository2->getOrder(37);

        $this->assertNotNull($retrievedOrder->getOrderNumber());
    }

}