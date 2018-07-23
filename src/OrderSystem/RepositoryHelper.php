<?php
/**
 * Filename: RepositoryHelper.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class RepositoryHelper
{
    public static function setFieldWhenReconstitutingFromPersistence($instance, $fieldName, $newValue)
    {
        $object = new \ReflectionObject($instance);
        $property = $object->getProperty($fieldName);
        $property->setAccessible(true);
        $property->setValue($instance, $newValue);
    }
}