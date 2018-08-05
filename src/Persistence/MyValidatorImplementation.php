<?php
/**
 * Filename: MyValidatorImplementation.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Persistence;


class MyValidatorImplementation implements Validator
{
    public function isValidatable($entity)
    {
        return is_a($entity, ValidatableRegardingPersistence::class);
    }

    public function isValid($entity)
    {
        return $entity->isValidRegardingPersistence();
    }

    public function genBrokenRules($entity)
    {
        return $entity->getBrokenRulesRegardingPersistence();
    }
}