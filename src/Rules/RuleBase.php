<?php
/**
 * Filename: RuleBase.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Rules;


use ReflectionClass;

abstract class RuleBase implements Rule
{

    private $fieldName;
    private $holder;
    private $reflectionProperty;
    private $participatingLogicalFields;

    public function __construct($participatingLogicalFields, $fieldName, $holder)
    {

        $this->fieldName = $fieldName;
        $this->holder = $holder;
        $this->participatingLogicalFields = $participatingLogicalFields;
        $this->init();
    }

    private function init(): void
    {
        $reflectedClass = new ReflectionClass(get_class($this->holder));
        $this->reflectionProperty = $reflectedClass->getProperty($this->fieldName);
        $this->reflectionProperty->setAccessible(true);
    }


    public static function collectBrokenRules($persistenceRelatedRules)
    {
        $brokenRules = [];
        foreach ($persistenceRelatedRules as $persistenceRelatedRule) {
            if (!$persistenceRelatedRule->isValid()) {
                foreach ($persistenceRelatedRule->getParticipatingLogicalFields() as $participatingLogicalField) {
                    $brokenRules[] = $participatingLogicalField;
                }
            }
        }
        return $brokenRules;
    }

    public function getValue()
    {
        return $this->reflectionProperty->getValue($this->holder);
    }

    public function getParticipatingLogicalFields()
    {
        return $this->participatingLogicalFields;
    }
}