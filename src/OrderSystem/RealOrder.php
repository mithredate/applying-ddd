<?php
/**
 * Filename: OrderSystem.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use DateTime;
use Mithredate\DDD\Misc\ApplicationException;
use Mithredate\DDD\Rules\BrokenRuleCollector;
use Mithredate\DDD\Rules\DateIsInRangeRule;
use Mithredate\DDD\Rules\MaxStringLengthRule;

class RealOrder implements Order
{
    private $customerSnapshot;
    private $orderDate;
    private $orderNumber;
    private $orderLines;
    private $note;
    private $customer;
    private $persistenceRelatedRules;
    private $acceptedSpecificRules;
    private $status;

    public function __construct($customer) {
        $this->customerSnapshot = $customer->takeSnapshot();
        $this->orderDate = new DateTime('now');
        $this->orderNumber = 0;
        $this->orderLines = [];
        $this->setStatus(OrderStatus::NEW);
        $this->customer = $customer;
        $this->setupPersistenceRelatedRules();
        $this->setupAcceptedSpecificRules();
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

    private function setupAcceptedSpecificRules()
    {
        $this->acceptedSpecificRules = [];
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
        $this->setStatus(OrderStatus::ORDERED);
    }

    public function getStatus()
    {
        return $this->status->getStatusNumber();
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

    public function setOrderDate($date)
    {
        $this->orderDate = $date;
    }

    public function isOKToAccept()
    {
        if (! $this->customer->isAccepted()) {
            return false;
        }

        return $this->isValidRegardingPersistence();
    }

    public function isValidRegardingPersistence()
    {
        return count($this->getBrokenRulesRegardingPersistence()) == 0;
    }

    public function getBrokenRulesRegardingPersistence()
    {
        $brokenRules = [];
        BrokenRuleCollector::collect($brokenRules, $this->persistenceRelatedRules);
        if ($this->isInThisStateOrBeyond(OrderStatus::ACCEPTED)) {
            BrokenRuleCollector::collect($brokenRules, $this->acceptedSpecificRules);
        }
        return $brokenRules;
    }

    public function getPersistenceRelatedRules()
    {
        return $this->persistenceRelatedRules;
    }

    public function isInThisStateOrBeyond($statusNumber)
    {
        return $this->status->isInThisStateOrBeyond($statusNumber);
    }

    public function accept()
    {
        if (!$this->isOKToAccept()) {
            throw new ApplicationException("Can't accept an invalid order.");
        }

        $this->setStatus(OrderStatus::ACCEPTED);
    }

    private function setStatus(int $statusNumber)
    {
        $this->status = new OrderStatus($statusNumber);
    }
}