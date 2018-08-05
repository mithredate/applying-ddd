<?php
/**
 * Filename: Query.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Infrastructure;


class Query
{
    private $type;
    private $criteria;

    public function __construct($type)
    {
        $this->type = $type;
        $this->criteria = [];
    }

    public function addCriteria($getter, $expected)
    {
        $this->criteria[] = new Criteria($getter, $expected);
    }

    public function getCriteria()
    {
        return $this->criteria;
    }
}