<?php
/**
 * Filename: OrderStatus.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\OrderSystem;


class OrderStatus
{
    const NEW = 0;
    const ACCEPTED = 1;
    const PERSISTED = 2;
    const REJECTED = 3;
    const ORDERED = 4;
    const INVALID = -1;
}