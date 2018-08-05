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
        if (!isset(self::$persistent[$this->type])) {
            self::$persistent[$this->type] = [];
        }
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

    public function getByQuery($query)
    {
        $result = [];
        foreach ($this->markedForPersistence as $item) {
            $matches = true;
            foreach ($query->getCriteria() as $criterion) {
                $actual = $item;
                foreach ($criterion->getGetterFields() as $getterField) {
                    $getterMethod = "get{$getterField}";
                    $actual = $actual->$getterMethod();
                }
                if ($actual != $criterion->getExpected()) {
                    $matches = false;
                    break;
                }
            }
            if ($matches) {
                $result[] = $item;
            }
        }
        return $result;
    }

    public function persistAll()
    {
        foreach ($this->markedForPersistence as $id => $entity) {
            self::$persistent[$this->type][$id] = $entity;
        }
        $this->markedForPersistence = [];
    }
}

