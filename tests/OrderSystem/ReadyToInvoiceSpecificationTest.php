<?php
/**
 * Filename: ReadyToInvoiceSpecificationTest.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Customer\Customer;
use PHPUnit\Framework\TestCase;

class ReadyToInvoiceSpecificationTest extends TestCase
{
    public function testNewOrderCanNotBeInvoiced()
    {
        $specification = new ReadyToInvoiceSpecification();

        $order = new RealOrder(new Customer());

        $this->assertFalse($specification->test($order));
    }
}