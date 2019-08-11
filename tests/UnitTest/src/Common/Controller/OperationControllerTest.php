<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IOperatAbleController;

class OperationControllerTest extends TestCase
{
    private $controller;

    private $childController;

    private $resource;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(OperationController::class)
                                 ->setMethods(['getController'])
                                 ->getMock();
                                 
        $this->childController = new class extends OperationController
        {
            public function getController(string $resource) : IOperatAbleController
            {
                return parent::getController($resource);
            }
        };

        $this->resource = 'tests';
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->childController);
        unset($this->resource);
    }

    public function testGetOperationController()
    {
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IOperatAbleController',
            $this->childController->getController($this->resource)
        );
    }

    public function testAdd()
    {
        $operationController = $this->prophesize(IOperatAbleController::class);
        $operationController->add()->shouldBeCalledTimes(1);
        $this->controller->expects($this->once())
                         ->method('getController')
                         ->with($this->resource)
                         ->willReturn($operationController->reveal());

        $this->controller->add($this->resource);
    }

    public function testEdit()
    {
        $id = 1;

        $operationController = $this->prophesize(IOperatAbleController::class);
        $operationController->edit(Argument::exact($id))->shouldBeCalledTimes(1);
        $this->controller->expects($this->once())
                         ->method('getController')
                         ->with($this->resource)
                         ->willReturn($operationController->reveal());

        $this->controller->edit($this->resource, $id);
    }
}
