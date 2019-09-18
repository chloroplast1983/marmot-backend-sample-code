<?php
namespace Common\Controller\Factory;

use PHPUnit\Framework\TestCase;

class FetchControllerFactoryTest extends TestCase
{
    public function testNullFetchController()
    {
        $controller = FetchControllerFactory::getFetchController('not exist');
        $this->assertInstanceOf('Common\Controller\NullFetchController', $controller);
    }

    public function testNewsFetchController()
    {
        $controller = FetchControllerFactory::getFetchController('news');
        $this->assertInstanceOf('News\Controller\FetchController', $controller);
    }

    public function testUserGroupsFetchController()
    {
        $controller = FetchControllerFactory::getFetchController('userGroups');
        $this->assertInstanceOf('UserGroup\Controller\FetchController', $controller);
    }
}
