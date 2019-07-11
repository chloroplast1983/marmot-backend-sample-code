<?php
namespace Common\Repository;

use Common\Model\IOperatAble;

trait OperatAbleRepositoryTrait
{
    public function add(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        return $this->getAdapter()->add($operatAbleObject, $keys);
    }

    public function edit(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        return $this->getAdapter()->edit($operatAbleObject, $keys);
    }
}
