<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;
use Mithredate\DDD\Rules\RuleBase;

class RealOrder implements Order
{
    private $customerSnapshot;
    private $orderDate;
    private $orderNumber;
    private $orderLines;
    private $status;
    private $note;
    private $customer;
    private $persistenceRelatedRules;

    public function __construct($customer) {
        $this->customerSnapshot = $customer->takeSnapshot();
        $this->orderDate = new DateTime('now');
        $this->orderNumber = 0;
        $this->orderLines = [];
        $this->status = OrderStatus::NEW;
        $this->customer = $customer;
        $this->setupPersistenceRelatedRules();
    }

    private function setupPersistenceRelatedRules()
    {
        $this->persistenceRelatedRules = [];

        $minDate = new DateTime('last year');
        $maxDate = new DateTime('now');
        $this->persistenceRelatedRules[] = new DateIsInRangeRule(
            $minDate,
            $maxDate,
            array("Order date is not valid."),
            "orderDate",
            $this
        );

        $this->persistenceRelatedRules[] = new MaxStringLengthRule(
            30,
            array("Note can't be longer than 30 characters."),
            "note",
            $this
        );
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
        $this->status = OrderStatus::ORDERED;
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
        $brokenRules = [];
        foreach ($this->persistenceRelatedRules as $persistenceRelatedRule) {
            if (!$persistenceRelatedRule->isValid()) {
                $brokenRules[] = $persistenceRelatedRule;
            }
        }
        return $brokenRules;
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

        $this->status = OrderStatus::ACCEPTED;
    }

    /**
     * @return mixed
     */
    public function getPersistenceRelatedRules()
    {
        return $this->persistenceRelatedRules;
    }
}