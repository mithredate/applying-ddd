<?php
/**
 * Filename: Validator.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Persistence;


interface Validator
{
    public function isValidatable($entity);

    public function isValid($entity);

    public function genBrokenRules($entity);
}