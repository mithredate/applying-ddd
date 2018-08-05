<?php
/**
 * Filename: OrderRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Infrastructure\Query;

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

    public function add($order)
    {
        $this->ws->markForPersistence($order);
    }

    public function getOrdersByCustomer($customer)
    {
        $query = new Query(Order::class);
        $query->addCriteria("CustomerSnapshot.CustomerNumber", $customer->getCustomerNumber());
        return $this->ws->getByQuery($query);
    }

    public function getOrders($customer)
    {
        // TODO: Implement getOrders() method.
    }
}