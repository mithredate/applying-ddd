<?php
/**
 * Filename: CustomerTest.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Customer;


use Mithredate\DDD\OrderSystem\Order;
use Mithredate\DDD\OrderSystem\OrderRepository;
use Mithredate\DDD\OrderSystem\ReadyToInvoiceSpecification;
use Mithredate\DDD\OrderSystem\RealOrder;
use Mithredate\DDD\Persistence\ValidatorThatDoesNothing;
use Mithredate\DDD\Persistence\WorkspaceFake;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{

    public function testCustomerWithNewOrdersDoNotHaveReadyToInvoice()
    {
        $customer = new Customer();
        $orderRepository = new OrderRepository(new WorkspaceFake(Order::class, 'getOrderNumber', new ValidatorThatDoesNothing()));
        $customer->setOrderRepository($orderRepository);

        $order = new RealOrder($customer);
        $orderRepository->add($order);

        $specification = new ReadyToInvoiceSpecification();

        $this->assertEquals(0, count($customer->getOrdersToInvoice($specification)));
    }
}