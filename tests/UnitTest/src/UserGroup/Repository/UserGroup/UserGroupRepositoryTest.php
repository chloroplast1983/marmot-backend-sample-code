<?php
namespace UserGroup\Repository\UserGroup;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use UserGroup\Adapter\UserGroup\IUserGroupAdapter;

class UserGroupRepositoryTest extends TestCase
{
    private $repository;
    
    private $childRepository;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(UserGroupRepository::class)
                           ->setMethods(['getAdapter'])
                           ->getMock();
                           
        $this->childRepository = new class extends UserGroupRepository
        {
            public function getActualAdapter() : IUserGroupAdapter
            {
                return parent::getActualAdapter();
            }

            public function getMockAdapter() : IUserGroupAdapter
            {
                return parent::getMockAdapter();
            }
        };
    }

    public function testCorrectInstanceExtendsRepository()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Classes\Repository',
            $this->repository
        );
    }

    public function testGetActualAdapter()
    {
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\IUserGroupAdapter',
            $this->childRepository->getActualAdapter()
        );
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\UserGroupDBAdapter',
            $this->childRepository->getActualAdapter()
        );
    }

    public function testGetMockAdapter()
    {
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\IUserGroupAdapter',
            $this->childRepository->getMockAdapter()
        );
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\UserGroupMockAdapter',
            $this->childRepository->getMockAdapter()
        );
    }

    public function testFetchOne()
    {
        $id = 1;

        $adapter = $this->prophesize(IUserGroupAdapter::class);
        $adapter->fetchOne(Argument::exact($id))
                ->shouldBeCalledTimes(1);

        $this->repository->expects($this->exactly(1))
                         ->method('getAdapter')
                         ->willReturn($adapter->reveal());

        $this->repository->fetchOne($id);
    }

    public function testFetchList()
    {
        $ids = [1, 2, 3];

        $adapter = $this->prophesize(IUserGroupAdapter::class);
        $adapter->fetchList(Argument::exact($ids))
                ->shouldBeCalledTimes(1);

        $this->repository->expects($this->exactly(1))
                         ->method('getAdapter')
                         ->willReturn($adapter->reveal());

        $this->repository->fetchList($ids);
    }

    public function testFilter()
    {
        $filter = array();
        $sort = array();
        $offset = 0;
        $size = 20;

        $adapter = $this->prophesize(IUserGroupAdapter::class);
        $adapter->filter(
            Argument::exact($filter),
            Argument::exact($sort),
            Argument::exact($offset),
            Argument::exact($size)
        )->shouldBeCalledTimes(1);

        $this->repository->expects($this->exactly(1))
                         ->method('getAdapter')
                         ->willReturn($adapter->reveal());
                
        $this->repository->filter($filter, $sort, $offset, $size);
    }
}
