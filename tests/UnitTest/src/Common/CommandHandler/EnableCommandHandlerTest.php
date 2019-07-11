<?php
namespace Common\CommandHandler;

use Common\Model\IEnableAble;
use Common\Command\EnableCommand;

use PHPUnit\Framework\TestCase;

class EnableCommandHandlerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(EnableCommandHandler::class)
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
            'Marmot\Framework\Interfaces\ICommandHandler',
            $this->stub
        );
    }

    public function testExecute()
    {
        $id =1;

        $command = new class($id) extends EnableCommand
        {

        };

        $enableAble = $this->prophesize(IEnableAble::class);
        $enableAble->enable()->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('fetchIEnableObject')
            ->with($id)
            ->willReturn($enableAble->reveal());

        $result = $this->stub->execute($command);
        $this->assertTrue($result);
    }
}
