<?php
/**
 * Filename: Customer.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


class Customer
{
    const NEW = 0;
    const ACCEPTED = 1;
    private $customerNumber;
    private $name;
    private $maxAmountOfDebt;
    private $status;

    /**
     * Customer constructor.
     *
     */
    public function __construct()
    {
        $this->maxAmountOfDebt = 0;
        $this->status = Customer::NEW;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function takeSnapshot()
    {
        return new CustomerSnapshot(
            $this->name,
            $this->customerNumber,
            $this->maxAmountOfDebt
        );
    }


    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    public function setMaxAmountOfDebt($maxAmountOfDebt)
    {
        $this->maxAmountOfDebt = $maxAmountOfDebt;
    }

    public function accept()
    {
        $this->status = self::ACCEPTED;
    }

    public function isAccepted()
    {
        return $this->status === self::ACCEPTED;
    }
}