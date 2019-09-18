<?php
namespace Common\Model;

class MockNullEnableAbleTrait
{
    use NullEnableAbleTrait;

    protected function resourceNotExist() : bool
    {
        return false;
    }

    public function publicUpdateStatus(int $status) : bool
    {
        return $this->updateStatus($status);
    }
}
