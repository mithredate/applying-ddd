<?php
/**
 * Filename: WorkSpace.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Persistence;


interface Workspace
{
    public function markForPersistence($entity);

    public function getById($type, $id);

    public function getByQuery($query);

//    public function getByParent($type, $parent, $parentId);

//    public function persistAll();
}