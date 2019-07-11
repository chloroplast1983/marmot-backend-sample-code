<?php
namespace Common\Model;

trait OperatAbleTrait
{
    public function add() : bool
    {
        return $this->addAction();
    }

    public function edit() : bool
    {
        return $this->editAction();
    }

    abstract protected function addAction() : bool;

    abstract protected function editAction() : bool;
}
