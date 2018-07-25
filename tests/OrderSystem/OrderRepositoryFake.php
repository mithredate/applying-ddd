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
        return isset($this->orders[$orderNumber]) ? $this->orders[$orderNumber] : new NoOrder();
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
            if($order->getCustomerNumber() == $customer->getCustomerNumber()) {
                $orders[] = $order;
            }
        }

        return $orders;
    }
}