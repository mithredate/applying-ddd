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
    private $maxAmountOfDebt;

    public function __construct(
        $customerName,
        $customerNumber,
        $maxAmountOfDebt
    ) {
        $this->customerName = $customerName;
        $this->customerNumber = $customerNumber;
        $this->maxAmountOfDebt = $maxAmountOfDebt;
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

    /**
     * @return mixed
     */
    public function getMaxAmountOfDebt()
    {
        return $this->maxAmountOfDebt;
    }

}