<?php
namespace Common\Controller\Factory;

use PHPUnit\Framework\TestCase;

class EnableControllerFactoryTest extends TestCase
{
    public function testNullEnableController()
    {
        $controller = EnableControllerFactory::getController('not exist');
        $this->assertInstanceOf('Common\Controller\NullEnableController', $controller);
    }

    public function testNewsEnableController()
    {
        $controller = EnableControllerFactory::getController('news');
        $this->assertInstanceOf('News\Controller\EnableController', $controller);
    }
}
