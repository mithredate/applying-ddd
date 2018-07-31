<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;

class RealOrder extends Order
{
    private $customerSnapshot;
    private $orderDate;
    private $orderNumber;
    private $orderLines;
    private $status;
    private $note;
    private $customer;

    public function __construct($customer) {
        $this->customerSnapshot = $customer->takeSnapshot();
        $this->orderDate = new DateTime('now');
        $this->orderNumber = 0;
        $this->orderLines = [];
        $this->status = self::NEW;
        $this->customer = $customer;
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
        return count($this->getBrokenRulesRegardingPersistence()) == 0;
    }

    public function setOrderDate($date)
    {
        $this->orderDate = $date;
    }

    public function getBrokenRulesRegardingPersistence()
    {
        $brokenRulesRegardingPersistence = [];
        $noteIsTooLong = strlen($this->note) > 30;
        if ($noteIsTooLong) {
            $brokenRulesRegardingPersistence[] = "Note is too long.";
        }

        $invalidOrderDate = $this->orderDate > new DateTime('now');
        if ($invalidOrderDate) {
            $brokenRulesRegardingPersistence[] = "Order date is in the future.";
        }
        return $brokenRulesRegardingPersistence;
    }

    public function isOKToAccept()
    {
        if (! $this->customer->isAccepted()) {
            return false;
        }

        return $this->isValidRegardingPersistence();
    }

    public function accept()
    {
        if (!$this->isOKToAccept()) {
            throw new ApplicationException("Can't accept an invalid order.");
        }

        $this->status = Order::ACCEPTED;
    }
}