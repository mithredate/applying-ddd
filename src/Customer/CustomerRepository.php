<?php
/**
 * Filename: CustomerRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


class CustomerRepository
{
    private $ws;

    public function __construct($workspace)
    {
        $this->ws = $workspace;
    }


    public function add($customer)
    {
        $this->ws->markForPersistence($customer);
    }

    public function getById($id)
    {
        return $this->ws->getById(Customer::class, $id);
    }
}