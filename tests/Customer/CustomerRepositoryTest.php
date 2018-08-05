<?php
/**
 * Filename: CustomerRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


use Mithredate\DDD\Misc\RepositoryHelper;
use Mithredate\DDD\Persistence\ValidatorThatDoesNothing;
use Mithredate\DDD\Persistence\WorkspaceFake;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryTest extends TestCase
{
    private $ws;
    private $repository;
    private $repositoryHelper;

    protected function setUp()
    {
        $this->ws = new WorkspaceFake(Customer::class, "getCustomerNumber", new ValidatorThatDoesNothing());
        $this->repository = new CustomerRepository($this->ws);
        $this->repositoryHelper = new RepositoryHelper();
    }

    public function testCanAddCustomer()
    {
        $this->fakeACustomer(1);
        $retrievedCustomer = $this->repository->getById(1);
        $this->assertEquals(1, $retrievedCustomer->getCustomerNumber());
    }


    private function fakeACustomer($customerNumber)
    {
        $this->repository->add($this->repositoryHelper->fakeACustomer($customerNumber));
    }
}