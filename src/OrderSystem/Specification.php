<?php
/**
 * Filename: Specification.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


interface Specification
{
    public function test($target);
}