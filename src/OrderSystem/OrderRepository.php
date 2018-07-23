<?php
/**
 * Filename: OrderRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class OrderRepository
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

    }

    public function addOrder($order)
    {
        $numberOfOrdersBefore = count($this->orders);

        $this->orders[] = $order;

        assert($numberOfOrdersBefore + 1 === count($this->orders));
    }
}