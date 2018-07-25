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
        return $this->ws->getById(Order::class, $orderNumber);
    }

    public function addOrder($order)
    {
        $numberOfOrdersBefore = count($this->orders);

        $this->orders[$order->getOrderNumber()] = $order;

        $this->ws->add(Order::class, $order, $order->getOrderNumber());

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