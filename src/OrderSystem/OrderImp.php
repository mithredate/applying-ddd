<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;

class OrderImp extends Order
{
    private $customerSnapshot;
    private $orderDate;
    private $orderNumber;
    private $orderLines;
    private $status;
    private $note;

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
        $this->guardOrderAmountLimit();
        if ($this->getTotalAmount() > $this->getCustomerMaxAmountOfDebt()) {
            throw new ApplicationException("Customer reached its maximum debt amount!");
        }
        $this->status = self::ORDERED;
    }

    public function getStatus()
    {
        return $this->status;
    }

    private function guardOrderAmountLimit(): void
    {
        if ($this->getTotalAmount() > 1000000) {
            throw new ApplicationException("Order amount can't exceed the limit!");
        }
    }

    public function getCustomerMaxAmountOfDebt()
    {
        return $this->customerSnapshot->getMaxAmountOfDebt();
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function isValidRegardingPersistence()
    {
        return strlen($this->note) <= 30;
    }
}