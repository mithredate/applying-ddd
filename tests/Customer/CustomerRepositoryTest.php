<?php
/**
 * Filename: CustomerRepository.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Customer;


use Mithredate\DDD\Misc\RepositoryHelper;
use Mithredate\DDD\Persistence\WorkspaceFake;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryTest extends TestCase
{
    public function testCanAddCustomer()
    {
        self::markTestSkipped();
        $customer = new Customer();
        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($customer, "customerNumber", 1);

        $ws = new WorkspaceFake(Customer::class, "getCustomerNumber");

        $customerRepository = new CustomerRepository($ws);
        $customerRepository->add($customer);
        $retrievedCustomer = $customerRepository->getById(Customer::class, 1);
        $this->assertEquals(1, $retrievedCustomer->getCustomerNumber());
    }
}