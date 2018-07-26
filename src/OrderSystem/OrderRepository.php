<?php
/**
 * Filename: OrderRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


interface OrderRepository
{
    public function getOrder($orderNumber);

    public function getOrders($customer);

    public function add($order);
}