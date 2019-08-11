<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IFetchAbleController;

class FetchControllerTest extends TestCase
{
    private $controller;

    private $childController;

    private $resource;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(FetchController::class)
                                 ->setMethods(['getFetchController'])
                                 ->getMock();

        $this->childController = new class extends FetchController
        {
            public function getFetchController(string $resource) : IFetchAbleController
            {
                return parent::getFetchController($resource);
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

    public function testGetFetchController()
    {
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IFetchAbleController',
            $this->childController->getFetchController($this->resource)
        );
    }

    public function testFilter()
    {
        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->filter()->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($this->resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->filter($this->resource);
    }

    public function testFetchList()
    {
        $ids = '1,2';

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchList(Argument::exact($ids))->shouldBeCalledTimes(1);
        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($this->resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->fetchList($this->resource, $ids);
    }

    public function testFetchOne()
    {
        $id = 1;

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchOne(Argument::exact($id))->shouldBeCalledTimes(1);
        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($this->resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->fetchOne($this->resource, $id);
    }
}
