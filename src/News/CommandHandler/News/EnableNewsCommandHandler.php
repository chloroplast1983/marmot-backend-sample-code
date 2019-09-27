<?php
namespace News\CommandHandler\News;

use Marmot\Interfaces\ICommandHandler;

use Common\Model\IEnableAble;
use Common\CommandHandler\EnableCommandHandler;

class EnableNewsCommandHandler extends EnableCommandHandler implements ICommandHandler
{
    use NewsCommandHandlerTrait;

    protected function fetchIEnableObject($id) : IEnableAble
    {
        return $this->fetchNews($id);
    }
}
