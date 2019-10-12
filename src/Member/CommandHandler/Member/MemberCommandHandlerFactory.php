<?php
namespace Member\CommandHandler\Member;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;
use Marmot\Interfaces\ICommandHandlerFactory;
use Marmot\Framework\Classes\NullCommandHandler;

class MemberCommandHandlerFactory implements ICommandHandlerFactory
{
    const MAPS = array(
        'Member\Command\Member\SignInMemberCommand'=>
        'Member\CommandHandler\Member\SignInMemberCommandHandler',
        'Member\Command\Member\SignUpMemberCommand'=>
        'Member\CommandHandler\Member\SignUpMemberCommandHandler',
    );

    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandClass = get_class($command);
        $commandHandler = isset(self::MAPS[$commandClass]) ? self::MAPS[$commandClass] : '';

        return class_exists($commandHandler) ? new $commandHandler : new NullCommandHandler();
    }
}
