<?php
namespace Common\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Controller\Interfaces\IFetchAbleController;

class FetchControllerTest extends TestCase
{
    private $controller;

    private $childController;

    public function setUp()
    {
        $this->controller = $this->getMockBuilder(FetchController::class)
                                 ->setMethods(['getFetchController'])
                                 ->getMock();

        $this->childController = new class extends FetchController{
            public function getFetchController(string $resource) : IFetchAbleController
            {
                return parent::getFetchController($resource);
            }
        };
    }

    public function tearDown()
    {
        unset($this->controller);
        unset($this->childController);
    }

    public function testGetFetchController()
    {
        $resource = 'services';
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IFetchAbleController',
            $this->childController->getFetchController($resource)
        );
    }

    public function testFilter()
    {
        $resource = 'test';

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->filter()->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->filter($resource);
    }

    public function testFetchList()
    {
        $resource = 'test';
        $ids = '1,2';

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchList(Argument::exact($ids))->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->fetchList($resource, $ids);
    }

    public function testFetchOne()
    {
        $resource = 'test';
        $id = 1;

        $fetchController = $this->prophesize(IFetchAbleController::class);
        $fetchController->fetchOne(Argument::exact($id))->shouldBeCalledTimes(1);

        $this->controller->expects($this->once())
                         ->method('getFetchController')
                         ->with($resource)
                         ->willReturn($fetchController->reveal());

        $this->controller->fetchOne($resource, $id);
    }
}
