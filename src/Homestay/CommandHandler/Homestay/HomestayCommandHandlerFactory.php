<?php
namespace Homestay\CommandHandler\Homestay;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;
use Marmot\Framework\Classes\NullCommandHandler;
use Marmot\Interfaces\ICommandHandlerFactory;

class HomestayCommandHandlerFactory implements ICommandHandlerFactory
{
    const MAPS = array(
        'Homestay\Command\Homestay\AddCommand'=>
        'Homestay\CommandHandler\Homestay\AddCommandHandler',
        'Homestay\Command\Homestay\EditCommand'=>
        'Homestay\CommandHandler\Homestay\EditCommandHandler',
    );

    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandClass = get_class($command);
        $commandHandler = isset(self::MAPS[$commandClass]) ? self::MAPS[$commandClass] : '';

        return class_exists($commandHandler) ? new $commandHandler : new NullCommandHandler();
    }
}
