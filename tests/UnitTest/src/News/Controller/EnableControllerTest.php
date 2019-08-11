<?php
namespace News\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Classes\CommandBus;

use News\Utils\ObjectGenerate;
use News\Repository\News\NewsRepository;
use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;

class EnableControllerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableController::class)
                    ->setMethods(['displayError',])->getMock();
    }

    public function teatDown()
    {
        unset($this->stub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'News\Repository\News\NewsRepository',
            $this->stub->getRepository()
        );
    }

    public function testGetCommandBus()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Classes\CommandBus',
            $this->stub->getCommandBus()
        );
    }

    private function initialDisable($result)
    {
        $this->stub = $this->getMockBuilder(TestEnableController::class)
                    ->setMethods([
                        'getCommandBus',
                        'getRepository',
                        'render',
                        'displayError'
                    ])->getMock();

        $id = 1;
        $command = new DisableNewsCommand($id);

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($result);
        $this->stub->expects($this->exactly(1))
             ->method('getCommandBus')
             ->willReturn($commandBus->reveal());

        return $command;
    }

    public function testDisableSuccess()
    {
        $command = $this->initialDisable(true);

        $news = ObjectGenerate::generateNews($command->id);

        $repository = $this->prophesize(NewsRepository::class);
        $repository->fetchOne(Argument::exact($command->id))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($news);
        $this->stub->expects($this->exactly(1))
             ->method('getRepository')
             ->willReturn($repository->reveal());
             
        $this->stub->expects($this->exactly(1))
        ->method('render');

        $result = $this->stub->disable($command->id);
        $this->assertTrue($result);
    }

    public function testDisableFailure()
    {
        $command = $this->initialDisable(false);

        $this->stub->expects($this->exactly(1))
             ->method('displayError');

        $result = $this->stub->disable($command->id);
        $this->assertFalse($result);
    }

    private function initialEnable($result)
    {
        $this->stub = $this->getMockBuilder(TestEnableController::class)
                    ->setMethods([
                        'getCommandBus',
                        'getRepository',
                        'render',
                        'displayError'
                    ])->getMock();

        $id = 1;
        $command = new EnableNewsCommand($id);

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($result);
        $this->stub->expects($this->exactly(1))
             ->method('getCommandBus')
             ->willReturn($commandBus->reveal());

        return $command;
    }

    public function testEnableSuccess()
    {
        $command = $this->initialEnable(true);

        $news = ObjectGenerate::generateNews($command->id);

        $repository = $this->prophesize(NewsRepository::class);
        $repository->fetchOne(Argument::exact($command->id))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($news);
        $this->stub->expects($this->exactly(1))
             ->method('getRepository')
             ->willReturn($repository->reveal());
             
        $this->stub->expects($this->exactly(1))
        ->method('render');

        $result = $this->stub->enable($command->id);
        $this->assertTrue($result);
    }

    public function testEnableFailure()
    {
        $command = $this->initialEnable(false);

        $this->stub->expects($this->exactly(1))
             ->method('displayError');

        $result = $this->stub->enable($command->id);
        $this->assertFalse($result);
    }
}
