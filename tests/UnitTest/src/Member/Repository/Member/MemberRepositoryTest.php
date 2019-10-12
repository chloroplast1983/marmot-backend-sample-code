<?php
namespace Member\Repository\Member;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Member\Adapter\Member\IMemberAdapter;

class MemberRepositoryTest extends TestCase
{
    private $repository;
    
    private $childRepository;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(MemberRepository::class)
                           ->setMethods(['getAdapter'])
                           ->getMock();
                           
        $this->childRepository = new class extends MemberRepository
        {
            public function getActualAdapter() : IMemberAdapter
            {
                return parent::getActualAdapter();
            }

            public function getMockAdapter() : IMemberAdapter
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
            'Member\Adapter\Member\IMemberAdapter',
            $this->childRepository->getActualAdapter()
        );
        $this->assertInstanceOf(
            'Member\Adapter\Member\MemberDBAdapter',
            $this->childRepository->getActualAdapter()
        );
    }

    public function testGetMockAdapter()
    {
        $this->assertInstanceOf(
            'Member\Adapter\Member\IMemberAdapter',
            $this->childRepository->getMockAdapter()
        );
        $this->assertInstanceOf(
            'Member\Adapter\Member\MemberMockAdapter',
            $this->childRepository->getMockAdapter()
        );
    }

    public function testFetchOne()
    {
        $id = 1;

        $adapter = $this->prophesize(IMemberAdapter::class);
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

        $adapter = $this->prophesize(IMemberAdapter::class);
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

        $adapter = $this->prophesize(IMemberAdapter::class);
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
