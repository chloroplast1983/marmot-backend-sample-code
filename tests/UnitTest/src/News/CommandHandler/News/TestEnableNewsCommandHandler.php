<?php
namespace News\CommandHandler\News;

use Common\Model\IEnableAble;

class TestEnableNewsCommandHandler extends EnableNewsCommandHandler
{
    public function fetchIEnableObject($id) : IEnableAble
    {
        return parent::fetchIEnableObject($id);
    }
}
