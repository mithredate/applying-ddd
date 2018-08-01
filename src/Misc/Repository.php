<?php
/**
 * Filename: Repository.
 * User: Mithredate
 * Date: Aug, 2018
 */

namespace Mithredate\DDD\Misc;


interface Repository
{
    public function getById($id);

    public function add($item);
}