<?php
namespace Common\CommandHandler;

use PHPUnit\Framework\TestCase;

use Common\Model\IEnableAble;
use Common\Command\DisableCommand;

class DisableCommandHandlerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DisableCommandHandler::class)
                    ->setMethods(['fetchIEnableObject'])
                    ->getMockForAbstractClass();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testImplementsICommandHandler()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\ICommandHandler',
            $this->stub
        );
    }

    public function testExecute()
    {
        $id =1;

        $command = new class($id) extends DisableCommand
        {
        };

        $disableAble = $this->prophesize(IEnableAble::class);
        $disableAble->disable()->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('fetchIEnableObject')
            ->with($id)
            ->willReturn($disableAble->reveal());

        $result = $this->stub->execute($command);
        $this->assertTrue($result);
    }
}
