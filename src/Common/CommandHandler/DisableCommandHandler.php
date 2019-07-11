<?php
namespace Common\CommandHandler;

use Marmot\Framework\Interfaces\ICommand;
use Marmot\Framework\Interfaces\ICommandHandler;

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
