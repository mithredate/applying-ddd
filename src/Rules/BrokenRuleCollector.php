<?php
/**
 * Filename: BrokenRuleCollector.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Rules;


class BrokenRuleCollector
{
    public static function collect(&$brokenRules, $rules)
    {
        foreach ($rules as $rule) {
            if (!$rule->isValid()) {
                $brokenRules[] = $rule;
            }
        }
    }
}