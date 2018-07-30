<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;

class OrderImp implements Order
{
    const NEW = 0;
    const ORDERED = 1;
    private $customerSnapshot;
    private $orderDate;
    private $orderNumber;
    private $orderLines;
    private $status;

    public function __construct($customer) {
        $this->customerSnapshot = $customer->takeSnapshot();
        $this->orderDate = new DateTime('now');
        $this->orderNumber = 0;
        $this->orderLines = [];
        $this->status = self::NEW;
    }

    public function getCustomerSnapshot()
    {
        return $this->customerSnapshot;
    }

    public function getOrderDate()
    {
        return $this->orderDate;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function getTotalAmount()
    {
        $theSum = 0;
        foreach ($this->orderLines as $orderLine) {
            $theSum += $orderLine->getTotalAmount();
        }
        return $theSum;
    }

    public function addOrderLine($orderLine)
    {
        $this->orderLines[] = $orderLine;
    }

    public function getCustomerName()
    {
        return $this->customerSnapshot->getCustomerName();
    }

    public function getCustomerNumber()
    {
        return $this->customerSnapshot->getCustomerNumber();
    }

    public function orderNow()
    {

    }

    public function getStatus()
    {
        return $this->status;
    }
}