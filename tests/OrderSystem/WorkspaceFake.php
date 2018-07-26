<?php
/**
 * Filename: WorkspaceFake.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class WorkspaceFake implements Workspace {

    private $count = 0;
    private $markedForPersistence = [];
    private static $persistent = [];

    public function markForPersistence($type, $entity, $id)
    {
        if (!isset($this->markedForPersistence[$type])) {
            $this->markedForPersistence[$type] = [];
        }
        $this->markedForPersistence[$type][$id] = $entity;
        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    public function getById($type, $id)
    {
        return isset($this->markedForPersistence[$type][$id]) ? $this->markedForPersistence[$type][$id] :
            (isset(self::$persistent[$type][$id]) ? self::$persistent[$type][$id] : new NoOrder());
    }
}
//    public function persistAll()
//    {
//        foreach ($this->dirty as $type => $entities) {
//            if (!isset($this->persistent[$type])) {
//                $this->persistent[$type] = [];
//            }
//            foreach ($entities as $entity) {
//                $this->persistent[$type][] = $entity;
//            }
//        }
//        $this->dirty = [];
//    }
