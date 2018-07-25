<?php
/**
 * Filename: WorkSpace.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


interface Workspace
{
    public function add($type, $entity, $id);
    public function getById($type, $id);
//    public function persistAll();
}