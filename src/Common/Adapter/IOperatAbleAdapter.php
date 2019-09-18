<?php
namespace Common\Adapter;

use Common\Model\IOperatAble;

interface IOperatAbleAdapter
{
    public function add(IOperatAble $operatAbleObject, array $keys = array()) : bool;

    public function edit(IOperatAble $operatAbleObject, array $keys = array()) : bool;
}
