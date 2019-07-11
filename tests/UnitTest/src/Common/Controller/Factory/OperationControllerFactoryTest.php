<?php
namespace Common\Controller\Factory;

use PHPUnit\Framework\TestCase;

class OperationControllerFactoryTest extends TestCase
{
    public function testNullOperationController()
    {
        $controller = OperationControllerFactory::getController('not exist');
        $this->assertInstanceOf('Common\Controller\NullOperationController', $controller);
    }

    public function testNewsOperationController()
    {
        $controller = OperationControllerFactory::getController('news');
        $this->assertInstanceOf('News\Controller\OperationController', $controller);
    }
}
