<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;
use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;

class NewsCommandHandlerFactoryTest extends TestCase
{
    private $commandHandler;

    private $faker;
    
    public function setUp()
    {
        $this->commandHandler = new NewsCommandHandlerFactory();
        
        $this->faker = \Faker\Factory::create('zh_CN');
    }

    public function tearDown()
    {
        unset($this->faker);
        unset($this->commandHandler);
    }

    public function testCorrectInstanceImplementCommandHandlerFactory()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\ICommandHandlerFactory',
            $this->commandHandler
        );
    }

    public function testAddNewsCommandHandler()
    {
        $commandHandler = $this->commandHandler->getHandler(
            new AddNewsCommand(
                $this->faker->title(),
                $this->faker->title(),
                array($this->faker->name()),
                array($this->faker->name()),
                $this->faker->word(),
                $this->faker->randomNumber(),
                $this->faker->randomDigit
            )
        );

        $this->assertInstanceOf('Marmot\Interfaces\ICommandHandler', $commandHandler);
        $this->assertInstanceOf(
            'News\CommandHandler\News\AddNewsCommandHandler',
            $commandHandler
        );
    }

    public function testEditNewsCommandHandler()
    {
        $commandHandler = $this->commandHandler->getHandler(
            new EditNewsCommand(
                $this->faker->title(),
                $this->faker->title(),
                array($this->faker->name()),
                array($this->faker->name()),
                $this->faker->word(),
                $this->faker->randomDigit
            )
        );
        
        $this->assertInstanceOf('Marmot\Interfaces\ICommandHandler', $commandHandler);
        $this->assertInstanceOf(
            'News\CommandHandler\News\EditNewsCommandHandler',
            $commandHandler
        );
    }

    public function testDisableNewsCommandHandler()
    {
        $commandHandler = $this->commandHandler->getHandler(
            new DisableNewsCommand(
                $this->faker->randomDigit
            )
        );
        
        $this->assertInstanceOf('Marmot\Interfaces\ICommandHandler', $commandHandler);
        $this->assertInstanceOf(
            'News\CommandHandler\News\DisableNewsCommandHandler',
            $commandHandler
        );
    }

    public function testEnableNewsCommandHandler()
    {
        $commandHandler = $this->commandHandler->getHandler(
            new EnableNewsCommand(
                $this->faker->randomDigit
            )
        );
        
        $this->assertInstanceOf('Marmot\Interfaces\ICommandHandler', $commandHandler);
        $this->assertInstanceOf(
            'News\CommandHandler\News\EnableNewsCommandHandler',
            $commandHandler
        );
    }
}
