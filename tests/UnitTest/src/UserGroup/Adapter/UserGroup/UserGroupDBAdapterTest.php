<?php
namespace UserGroup\Adapter\UserGroup;

use Marmot\Core;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use UserGroup\Utils\ObjectGenerate;
use UserGroup\Translator\UserGroupDBTranslator;
use UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery;

class UserGroupDBAdapterTest extends TestCase
{
    private $translator;

    private $rowCacheQuery;
    
    private $adapter;

    public function setUp()
    {
        $this->adapter = $this->getMockBuilder(TestUserGroupDBAdapter::class)
        ->setMethods(['formatSort'])
        ->getMock();

        $this->translator = $this->prophesize(UserGroupDBTranslator::class);
        $this->rowCacheQuery = $this->prophesize(UserGroupRowCacheQuery::class);
    }

    public function tearDown()
    {
        unset($this->adapter);
        unset($this->translator);
        unset($this->rowCacheQuery);
    }

    public function testGetDBTranslator()
    {
        $this->assertInstanceOf(
            'UserGroup\Translator\UserGroupDBTranslator',
            $this->adapter->getDBTranslator()
        );
    }

    public function testGetRowCacheQuery()
    {
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery',
            $this->adapter->getRowCacheQuery()
        );
    }

    public function testFetchOneFailure()
    {
        $adapter = $this->getMockBuilder(TestUserGroupDBAdapter::class)
                        ->setMethods(['getRowCacheQuery'])
                        ->getMock();
                        
        $id = 1;
        $info = array();

        $this->rowCacheQuery->getOne(Argument::exact($id))
                            ->shouldBeCalledTimes(1)
                            ->willReturn($info);

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());

        $result = $adapter->fetchOne($id);
        $this->assertInstanceOf('UserGroup\Model\NullUserGroup', $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
  
    public function testFetchOneSuccess()
    {
        $adapter = $this->getMockBuilder(TestUserGroupDBAdapter::class)
                ->setMethods([
                    'getRowCacheQuery',
                    'getDBTranslator'
                ])->getMock();

        $id = 1;
        $info = array('info');
        $userGroup = ObjectGenerate::generateUserGroup($id);

        $this->rowCacheQuery->getOne(Argument::exact($id))
                                          ->shouldBeCalledTimes(1)
                                          ->willReturn($info);

        $this->translator->arrayToObject(Argument::exact($info))
                                         ->shouldBeCalledTimes(1)
                                         ->willReturn($userGroup);

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());
        $adapter->expects($this->exactly(1))
                ->method('getDBTranslator')
                ->willReturn($this->translator->reveal());

        $result = $adapter->fetchOne($id);
        $this->assertEquals($result, $userGroup);
    }

    public function testFetchListFail()
    {
        $adapter = $this->getMockBuilder(UserGroupDBAdapter::class)
                        ->setMethods(['getRowCacheQuery'])
                        ->getMock();
                        
        $ids = [1, 2];
        $userGroupList = array();

        $this->rowCacheQuery->getList(Argument::exact($ids))
                            ->shouldBeCalledTimes(1)
                            ->willReturn($userGroupList);

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());

        $result = $adapter->fetchList($ids);
        $this->assertEquals([], $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testFetchListSuccess()
    {
        $adapter = $this->getMockBuilder(UserGroupDBAdapter::class)
                        ->setMethods([
                            'getRowCacheQuery',
                            'getDBTranslator',
                        ])->getMock();
                        
        $ids = [1];

        $userGroupInfoList = array(array('userGroupList'));
        
        $userGroup = ObjectGenerate::generateUserGroup(1);
        $userGroupList = array($userGroup);

        $this->rowCacheQuery->getList(Argument::exact($ids))
                            ->shouldBeCalledTimes(1)
                            ->willReturn($userGroupInfoList);

        foreach ($userGroupInfoList as $userGroupInfo) {
            $this->translator->arrayToObject(Argument::exact($userGroupInfo))
            ->shouldBeCalledTimes(1)
            ->willReturn($userGroup);
        }

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());
        $adapter->expects($this->exactly(1))
                ->method('getDBTranslator')
                ->willReturn($this->translator->reveal());

        $result = $adapter->fetchList($ids);
        $this->assertEquals($result, $userGroupList);
    }
}
