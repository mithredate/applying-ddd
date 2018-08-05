<?php
/**
 * Filename: WorkspaceFake.
 * User: Mithredate
 * Date: Jul, 2018
 */

namespace Mithredate\DDD\Persistence;


use Mithredate\DDD\Misc\ApplicationException;

class WorkspaceFake implements Workspace {


    private $idGetter;
    private $markedForPersistence = [];
    private static $persistent = [];
    private $type;
    private $validator;

    /**
     * WorkspaceFake constructor.
     * @param $type
     * @param $idGetter
     * @param $validator
     */
    public function __construct($type, $idGetter, $validator)
    {
        $this->idGetter = $idGetter;
        $this->type = $type;
        if (!isset(self::$persistent[$this->type])) {
            self::$persistent[$this->type] = [];
        }
        $this->validator = $validator;
    }

    public function markForPersistence($entity)
    {
        $this->markedForPersistence[$entity->{$this->idGetter}()] = $entity;
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
            $this->guardInvalidRecordPersistence($entity);
            self::$persistent[$this->type][$id] = $entity;
        }
        $this->markedForPersistence = [];
    }

    private function guardInvalidRecordPersistence($entity)
    {
        if (
            $this->getValidator()->isValidatable($entity) &&
            ! $this->getValidator()->isValid($entity)
        ) {
            $brokenRules = $this->getValidator()->genBrokenRules($entity);
            $numberOfBrokenRules = count($brokenRules);
            throw new ApplicationException("Can't persist the entity. {$numberOfBrokenRules} rules failed!");
        }
    }

    public function getValidator()
    {
        return $this->validator;
    }

}

