<?php
/**
 * Filename: OrderStatus.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class OrderStatus
{
    const INVALID = -1;
    const NEW = 0;
    const REJECTED = 1;
    const ACCEPTED = 2;
    const PERSISTED = 3;
    const ORDERED = 4;
    private $statusNumber;

    public function __construct($statusNumber)
    {
        $this->statusNumber = $statusNumber;
    }

    public function getStatusNumber()
    {
        return $this->statusNumber;
    }

    public function isInThisStateOrBeyond($statusNumber)
    {
        return $this->getStatusNumber() > $statusNumber;
    }
}