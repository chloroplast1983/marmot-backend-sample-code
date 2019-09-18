<?php
namespace News\CommandHandler\News;

use Marmot\Framework\Interfaces\ICommand;
use Marmot\Framework\Interfaces\ICommandHandler;
use Marmot\Framework\Classes\NullCommandHandler;
use Marmot\Framework\Interfaces\ICommandHandlerFactory;

class NewsCommandHandlerFactory implements ICommandHandlerFactory
{
    const MAPS = array(
        'News\Command\News\AddNewsCommand'=>
        'News\CommandHandler\News\AddNewsCommandHandler',
        'News\Command\News\EditNewsCommand'=>
        'News\CommandHandler\News\EditNewsCommandHandler',
        'News\Command\News\EnableNewsCommand'=>
        'News\CommandHandler\News\EnableNewsCommandHandler',
        'News\Command\News\DisableNewsCommand'=>
        'News\CommandHandler\News\DisableNewsCommandHandler',
    );

    public function getHandler(ICommand $command) : ICommandHandler
    {
        $commandClass = get_class($command);
        $commandHandler = isset(self::MAPS[$commandClass]) ? self::MAPS[$commandClass] : '';

        return class_exists($commandHandler) ? new $commandHandler : new NullCommandHandler();
    }
}
