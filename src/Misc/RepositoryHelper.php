<?php
/**
 * Filename: RepositoryHelper.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Misc;


use Mithredate\DDD\Customer\Customer;
use Mithredate\DDD\OrderSystem\RealOrder;

class RepositoryHelper
{
    public static function setFieldWhenReconstitutingFromPersistence($instance, $fieldName, $newValue)
    {
        $object = new \ReflectionObject($instance);
        $property = $object->getProperty($fieldName);
        $property->setAccessible(true);
        $property->setValue($instance, $newValue);
    }

    public function fakeAnOrder($theOrderNumber, $customer)
    {
        $order = new RealOrder($customer);
        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($order, 'orderNumber', $theOrderNumber);
        return $order;
    }

    public function fakeACustomer($customerNumber)
    {
        $customer = new Customer();

        RepositoryHelper::setFieldWhenReconstitutingFromPersistence($customer, 'customerNumber', $customerNumber);

        return $customer;
    }
}