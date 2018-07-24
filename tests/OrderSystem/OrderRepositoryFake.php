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

    /**
     * OrderRepository constructor.
     */
    public function __construct()
    {
        $this->orders = [];
    }

    public function getOrder($orderNumber)
    {
        return $this->orders[$orderNumber];
    }

    public function addOrder($order)
    {
        $numberOfOrdersBefore = count($this->orders);

        $this->orders[$order->getOrderNumber()] = $order;

        assert($numberOfOrdersBefore + 1 === count($this->orders));
    }

    public function getOrders($customer)
    {
        $orders = [];

        foreach ($this->orders as $order) {
            if($order->getCustomer() == $customer) {
                $orders[] = $order;
            }
        }

        return $orders;
    }
}