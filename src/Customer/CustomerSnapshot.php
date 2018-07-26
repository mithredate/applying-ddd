<?php
/**
 * Filename: CustomerSnapshot.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


class CustomerSnapshot
{
    private $customerName;
    private $customerNumber;

    public function __construct(
        $customerName,
        $customerNumber
    ) {
        $this->customerName = $customerName;
        $this->customerNumber = $customerNumber;
    }

    /**
     * @return mixed
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @return mixed
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

}