<?php
/**
 * Filename: ValidatorThatDoesNothing.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Persistence;


class ValidatorThatDoesNothing implements Validator
{

    public function isValidatable($entity)
    {
        return false;
    }

    public function isValid($entity)
    {
        return false;
    }

    public function genBrokenRules($entity)
    {
        return array();
    }
}