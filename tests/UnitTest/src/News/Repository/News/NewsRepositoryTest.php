<?php
namespace News\Repository\News;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use News\Adapter\News\INewsAdapter;

class NewsRepositoryTest extends TestCase
{
    private $repository;
    
    private $childRepository;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(NewsRepository::class)
                           ->setMethods(['getAdapter'])
                           ->getMock();
                           
        $this->childRepository = new class extends NewsRepository
        {
            public function getActualAdapter() : INewsAdapter
            {
                return parent::getActualAdapter();
            }

            public function getMockAdapter() : INewsAdapter
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
            'News\Adapter\News\INewsAdapter',
            $this->childRepository->getActualAdapter()
        );
        $this->assertInstanceOf(
            'News\Adapter\News\NewsDBAdapter',
            $this->childRepository->getActualAdapter()
        );
    }

    public function testGetMockAdapter()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\INewsAdapter',
            $this->childRepository->getMockAdapter()
        );
        $this->assertInstanceOf(
            'News\Adapter\News\NewsMockAdapter',
            $this->childRepository->getMockAdapter()
        );
    }

    public function testFetchOne()
    {
        $id = 1;

        $adapter = $this->prophesize(INewsAdapter::class);
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

        $adapter = $this->prophesize(INewsAdapter::class);
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

        $adapter = $this->prophesize(INewsAdapter::class);
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
