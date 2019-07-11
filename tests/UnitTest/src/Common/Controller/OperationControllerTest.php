<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IOperatAbleController;

class OperationControllerTest extends TestCase
{
    private $controller;

    private $childController;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(OperationController::class)
                                 ->setMethods(['getController'])
                                 ->getMock();
                                 
        $this->childController = new class extends OperationController{
            public function getController(string $resource) : IOperatAbleController
            {
                return parent::getController($resource);
            }
        };
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->childController);
    }

    public function testGetOperationController()
    {
        $resource = 'services';
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IOperatAbleController',
            $this->childController->getController($resource)
        );
    }

    public function testAdd()
    {
        $resource = 'test';

        $operationController = $this->prophesize(IOperatAbleController::class);
        $operationController->add()->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getController')
                         ->with($resource)
                         ->willReturn($operationController->reveal());

        $this->controller->add($resource);
    }

    public function testEdit()
    {
        $resource = 'test';
        $id = 1;

        $operationController = $this->prophesize(IOperatAbleController::class);
        $operationController->edit(Argument::exact($id))->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getController')
                         ->with($resource)
                         ->willReturn($operationController->reveal());

        $this->controller->edit($resource, $id);
    }
}
