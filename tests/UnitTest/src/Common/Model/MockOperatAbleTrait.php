<?php
namespace Common\Model;

class MockOperatAbleTrait implements IOperatAble
{
    use OperatAbleTrait;

    protected function addAction() : bool
    {
        return true;
    }

    protected function editAction() : bool
    {
        return true;
    }
}
