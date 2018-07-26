<?php
/**
 * Filename: Customer.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


class Customer
{
    private $customerNumber;
    private $name;

    /**
     * Customer constructor.
     *
     */
    public function __construct()
    {
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
            $this->customerNumber
        );
    }

    /**
     * @return mixed
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }
}