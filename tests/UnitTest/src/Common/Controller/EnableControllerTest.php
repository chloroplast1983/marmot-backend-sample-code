<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IEnableAbleController;

class EnableControllerTest extends TestCase
{
    private $controller;

    private $resource;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(EnableController::class)
                                 ->setMethods(['getController'])
                                 ->getMock();

        $this->resource = 'tests';
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->resource);
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
        $id = 1;

        $enableController = $this->prophesize(IEnableAbleController::class);
        $enableController->enable(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn(true);
        $this->controller->expects($this->exactly(1))
                         ->method('getController')
                         ->with($this->resource)
                         ->willReturn($enableController->reveal());

        $result = $this->controller->enable($this->resource, $id);
        $this->assertTrue($result);
    }

    public function testDisable()
    {
        $id = 1;

        $disableController = $this->prophesize(IEnableAbleController::class);
        $disableController->disable(Argument::exact($id))->shouldBeCalledTimes(1)->willReturn(true);
        $this->controller->expects($this->exactly(1))
                         ->method('getController')
                         ->with($this->resource)
                         ->willReturn($disableController->reveal());

        $result = $this->controller->disable($this->resource, $id);
        $this->assertTrue($result);
    }
}
