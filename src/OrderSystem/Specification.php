<?php
/**
 * Filename: Specification.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace OrderSystem;


interface Specification
{
    public function test($target);
}