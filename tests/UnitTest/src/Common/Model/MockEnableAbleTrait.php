<?php
namespace Common\Model;

class MockEnableAbleTrait implements IEnableAble
{
    use EnableAbleTrait;

    private $status;

    public function getStatus() : int
    {
        return $this->status;
    }

    protected function updateStatus(int $status) : bool
    {
        return true;
    }
}
