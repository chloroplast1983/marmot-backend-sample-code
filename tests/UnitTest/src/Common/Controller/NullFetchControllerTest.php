<?php
namespace Common\Controller;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class NullFetchControllerTest extends TestCase
{
    private $controller;
    
    public function setUp()
    {
        $this->controller = new NullFetchController();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        Core::setLastError(ERROR_NOT_DEFINED);
        unset($this->controller);
    }

    public function testImplementIFetchController()
    {
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IFetchAbleController',
            $this->controller
        );
    }

    public function testImplementINull()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\INull',
            $this->controller
        );
    }

    public function testFilter()
    {
        $this->controller->filter();
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }

    public function testFetchList()
    {
        $this->controller->fetchList(0);
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }

    public function testFetchOne()
    {
        $this->controller->fetchOne(0);
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }
}
