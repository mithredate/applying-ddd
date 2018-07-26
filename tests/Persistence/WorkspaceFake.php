<?php
/**
 * Filename: WorkspaceFake.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Persistence;


class WorkspaceFake implements Workspace {


    private $idGetter;
    private $count = 0;
    private $markedForPersistence = [];
    private static $persistent = [];
    private $type;

    public function __construct($type, $idGetter)
    {
        $this->idGetter = $idGetter;
        $this->type = $type;
    }

    public function markForPersistence($entity)
    {
        $this->markedForPersistence[$entity->{$this->idGetter}()] = $entity;
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
        return isset($this->markedForPersistence[$id]) ? $this->markedForPersistence[$id] :
            (isset(self::$persistent[$this->type][$id]) ? self::$persistent[$this->type][$id] : null);
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
