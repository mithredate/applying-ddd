<?php
/**
 * Filename: WorkSpace.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


interface Workspace
{
    public function add($type, $value);

//    public function persistAll();
}