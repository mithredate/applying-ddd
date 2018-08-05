<?php
/**
 * Filename: Criteria.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Infrastructure;


class Criteria
{
    private $getter;
    private $expected;
    private $getterFields;

    public function __construct($getter, $value)
    {
        $this->getter = $getter;
        $this->expected = $value;
        $this->parse();
    }

    private function parse()
    {
        $this->getterFields = explode('.', $this->getter);
    }

    /**
     * @return mixed
     */
    public function getGetterFields()
    {
        return $this->getterFields;
    }

    /**
     * @return mixed
     */
    public function getExpected()
    {
        return $this->expected;
    }

}