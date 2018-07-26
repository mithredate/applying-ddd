<?php
/**
 * Filename: OrderRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class OrderRepositoryFake implements OrderRepository
{
    private $orders;
    private $ws;

    /**
     * OrderRepository constructor.
     *
     * @param $workspace
     */
    public function __construct($workspace)
    {
        $this->orders = [];
        $this->ws = $workspace;
    }

    public function getOrder($orderNumber)
    {
        $retrievedFromWorkspace = $this->ws->getById(Order::class, $orderNumber);
        $order = !is_null($retrievedFromWorkspace) ? $retrievedFromWorkspace: new NoOrder();
        return $order;
    }

    public function addOrder($order)
    {
        $numberOfOrdersBefore = count($this->orders);

        $this->orders[$order->getOrderNumber()] = $order;

        $this->ws->markForPersistence($order);

        assert($numberOfOrdersBefore + 1 === count($this->orders));
    }

    public function getOrders($customer)
    {
        $orders = [];

        foreach ($this->orders as $order) {
            if($order->getCustomerNumber() == $customer->getCustomerNumber()) {
                $orders[] = $order;
            }
        }

        return $orders;
    }
}