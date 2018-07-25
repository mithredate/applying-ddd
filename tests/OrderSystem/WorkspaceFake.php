<?php
/**
 * Filename: WorkspaceFake.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class WorkspaceFake implements Workspace {

    private $count = 0;
    private $dirty = [];
    private $persistent = [];

    public function add($type, $entity, $id)
    {
        if (!isset($this->dirty[$type])) {
            $this->dirty[$type] = [];
        }
        $this->dirty[$type][$id] = $entity;
        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

//    public function getById($type, $id)
//    {
//        $entity = isset($this->dirty[$type][$])
//    }

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

}