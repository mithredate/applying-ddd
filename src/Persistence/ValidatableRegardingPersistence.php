<?php
/**
 * Filename: ValidatableRegardingPersistence.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Persistence;


interface ValidatableRegardingPersistence
{
    public function isValidRegardingPersistence();

    public function getBrokenRulesRegardingPersistence();

    public function getPersistenceRelatedRules();
}