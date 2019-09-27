<?php
namespace Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Common\Model\IEnableAble;
use Common\Command\DisableCommand;

abstract class DisableCommandHandler implements ICommandHandler
{
    abstract protected function fetchIEnableObject($id) : IEnableAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(DisableCommand $command)
    {
        $this->enableAble = $this->fetchIEnableObject($command->id);

        return $this->enableAble->disable();
    }
}
