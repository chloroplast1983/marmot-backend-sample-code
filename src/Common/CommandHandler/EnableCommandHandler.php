<?php
namespace Common\CommandHandler;

use Marmot\Framework\Interfaces\ICommand;
use Marmot\Framework\Interfaces\ICommandHandler;

use Common\Model\IEnableAble;
use Common\Command\EnableCommand;

abstract class EnableCommandHandler implements ICommandHandler
{
    abstract protected function fetchIEnableObject($id) : IEnableAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(EnableCommand $command)
    {
        $this->enableAble = $this->fetchIEnableObject($command->id);
        return $this->enableAble->enable();
    }
}
