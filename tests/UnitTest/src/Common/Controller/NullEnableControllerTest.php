<?php
namespace Common\Controller;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class NullEnableControllerTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        $this->controller = new NullEnableController();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        Core::setLastError(ERROR_NOT_DEFINED);
        unset($this->controller);
    }

    public function testImplementIEnableController()
    {
        $this->assertInstanceOf(
            'Common\Controller\Interfaces\IEnableAbleController',
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

    public function testEnable()
    {
        $this->controller->enable(0);
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }

    public function testDisable()
    {
        $this->controller->disable(0);
        $this->assertEquals(Core::getLastError()->getId(), ROUTE_NOT_EXIST);
    }
}
