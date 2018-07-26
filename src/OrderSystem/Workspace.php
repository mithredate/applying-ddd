<?php
/**
 * Filename: WorkSpace.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


interface Workspace
{
    public function markForPersistence($type, $entity, $id);

    public function getById($type, $id);

//    public function getByParent($type, $parent, $parentId);

//    public function persistAll();
}