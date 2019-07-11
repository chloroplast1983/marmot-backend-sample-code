<?php
namespace News\CommandHandler\News;

use Common\Model\IEnableAble;

class TestDisableNewsCommandHandler extends DisableNewsCommandHandler
{
    public function fetchIEnableObject($id) : IEnableAble
    {
        return parent::fetchIEnableObject($id);
    }
}
