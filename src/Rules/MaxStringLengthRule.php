<?php
/**
 * Filename: MaxStringLenghtRule.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Rules;


class MaxStringLengthRule extends RuleBase
{
    private $maxLength;

    public function __construct($maxLength, $participatingLogicalFields, $fieldName, $holder)
    {
        parent::__construct($participatingLogicalFields, $fieldName, $holder);
        $this->maxLength = $maxLength;
    }


    public function isValid()
    {
        $length = strlen($this->getValue());

        return $length <= $this->maxLength;
    }
}