<?php
/**
 * Filename: Rule.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Rules;


interface Rule
{
    public function isValid();

    public function getParticipatingLogicalFields();
}