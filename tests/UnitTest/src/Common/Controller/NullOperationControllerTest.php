<?php
namespace Common\Controller;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class NullOperationControllerTest extends TestCase
{
    private $controller;
    
    public function setUp()
    {
        $this->controller = new NullOperationController();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        Core::setLastError(ERROR_NOT_DEFINED);
        unset($this->controller);
    }
    
    public function testImplementIOperatAbleController()
    {
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IOperatAbleController',
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

    public function testAdd()
    {
        $this->controller->add();
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }

    public function testEdit()
    {
        $this->controller->edit(0);
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }
}
