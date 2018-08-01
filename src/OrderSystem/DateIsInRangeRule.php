<?php
/**
 * Filename: DateIsInRangeRule.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


use Mithredate\DDD\Rules\RuleBase;

class DateIsInRangeRule extends RuleBase
{
    private $minDate;
    private $maxDate;

    public function __construct(
        $minDate,
        $maxDate,
        $participatingLogicalFields,
        $fieldName,
        $holder
    ) {
        parent::__construct($participatingLogicalFields, $fieldName, $holder);
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
    }


    public function isValid()
    {
        $currentDate = $this->getValue();
        return $currentDate <= $this->maxDate && $currentDate >= $this->minDate;
    }
}