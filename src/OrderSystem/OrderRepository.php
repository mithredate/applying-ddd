<?php
/**
 * Filename: OrderRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use ReflectionClass;

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
        return $this->orders[$orderNumber];
    }

    public function addOrder($order)
    {
        $numberOfOrdersBefore = count($this->orders);

        $this->orders[$order->getOrderNumber()] = $order;

        assert($numberOfOrdersBefore + 1 === count($this->orders));
    }

    public static function setFieldWhenReconstitutingFromPersistence($instance, $fieldName, $newValue)
    {
        $object = new \ReflectionObject($instance);
        $property = $object->getProperty($fieldName);
        $property->setAccessible(true);
        $property->setValue($instance, $newValue);
    }
}