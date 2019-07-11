<?php
namespace Common\Controller;

use Common\Controller\Interfaces\IEnableAbleController;
use Marmot\Core;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnableControllerTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(EnableController::class)
                                ->setMethods(['getController'])
                                ->getMock();
    }

    public function tearDown()
    {
        unset($this->controller);
    }

    public function testExtendsController()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Classes\Controller',
            $this->controller
        );
    }

    public function testEnable()
    {
        $resource = 'resource';
        $id = 1;

        $enableController = $this->prophesize(IEnableAbleController::class);
        $enableController->enable(Argument::exact($id))
                         ->shouldBeCalledTimes(1)
                         ->willReturn(true);
        $this->controller->expects($this->exactly(1))
                         ->method('getController')
                         ->with($resource)
                         ->willReturn($enableController->reveal());

         $result = $this->controller->enable($resource, $id);
         $this->assertTrue($result);
    }

    public function testDisable()
    {
        $resource = 'resource';
        $id = 1;

        $disableController = $this->prophesize(IEnableAbleController::class);
        $disableController->disable(Argument::exact($id))
                         ->shouldBeCalledTimes(1)
                         ->willReturn(true);
        $this->controller->expects($this->exactly(1))
                         ->method('getController')
                         ->with($resource)
                         ->willReturn($disableController->reveal());

         $result = $this->controller->disable($resource, $id);
         $this->assertTrue($result);
    }
}
