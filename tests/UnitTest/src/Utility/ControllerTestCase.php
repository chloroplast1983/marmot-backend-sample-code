<?php
namespace Utility;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

class ControllerTestCase extends TestCase
{
    const DEFAULT_ID=1;
    const TEST_IDS = '1,2';
    const EXPLODE_CHAR = ',';

    private $stub;

    public function setUp()
    {
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->stub);
    }

    protected function initialFetchOne($classList, $mockMethod, $object)
    {
        $this->stub = $this->getMockBuilder($classList['controller'])
                    ->setMethods([$mockMethod, 'renderView', 'displayError'])
                    ->getMock();

        $repository = $this->prophesize($classList['repository']);

        $repository->fetchOne(Argument::exact(self::DEFAULT_ID))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($object);

        $this->stub->expects($this->once())
                             ->method($mockMethod)
                             ->willReturn($repository->reveal());
    }
 
    protected function fetchOneSuccess($classList, $mockMethod, $object)
    {
        $this->initialFetchOne($classList, $mockMethod, $object);
        
        $this->stub->expects($this->exactly(1))
        ->method('renderView')
        ->willReturn(true);
        
        $result = $this->stub->fetchOne(self::DEFAULT_ID);
        $this->assertTrue($result);
    }

    protected function fetchOneFailure($classList, $mockMethod, $object)
    {
        $this->initialFetchOne($classList, $mockMethod, $object);
        
        $this->stub->expects($this->exactly(1))
        ->method('displayError')
        ->willReturn(false);
        
        $result = $this->stub->fetchOne(self::DEFAULT_ID);

        $this->assertFalse($result);
    }

    protected function initialFetchList($classList, $mockMethod, $array)
    {
        $this->stub = $this->getMockBuilder($classList['controller'])
                    ->setMethods([$mockMethod, 'renderView', 'displayError'])
                    ->getMock();

        $ids = explode(self::EXPLODE_CHAR, self::TEST_IDS);

        $repository = $this->prophesize($classList['repository']);

        $repository->fetchList(Argument::exact($ids))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($array);

        $this->stub->expects($this->once())
                             ->method($mockMethod)
                             ->willReturn($repository->reveal());
    }
 
    protected function fetchListSuccess($classList, $mockMethod, $array)
    {
        $this->initialFetchList($classList, $mockMethod, $array);
        
        $this->stub->expects($this->exactly(1))
        ->method('renderView')
        ->willReturn(true);
        
        $result = $this->stub->fetchList(self::TEST_IDS);
        $this->assertTrue($result);
    }

    protected function fetchListFailure($classList, $mockMethod, $array)
    {
        $this->initialFetchList($classList, $mockMethod, $array);
        
        $this->stub->expects($this->exactly(1))
        ->method('displayError')
        ->willReturn(false);
        
        $result = $this->stub->fetchList(self::TEST_IDS);

        $this->assertFalse($result);
    }

    protected function initialFilter($classList, $mockMethod, $array)
    {
        $this->stub = $this->getMockBuilder($classList['controller'])
                    ->setMethods([$mockMethod, 'renderView', 'displayError', 'formatParameters'])
                    ->getMock();

        $filter = array();
        $sort = array();
        $curpage = 1;
        $perpage = 20;

        $this->stub->expects($this->any())
        ->method('formatParameters')
        ->willReturn([$filter, $sort, $curpage, $perpage]);

        $repository = $this->prophesize($classList['repository']);

        $repository->filter(
            Argument::exact($filter),
            Argument::exact($sort),
            Argument::exact(($curpage-1)*$perpage),
            Argument::exact($perpage)
        )->shouldBeCalledTimes(1)->willReturn($array);

        $this->stub->expects($this->once())
                             ->method($mockMethod)
                             ->willReturn($repository->reveal());
    }
 
    protected function filterSuccess($classList, $mockMethod, $array)
    {
        $this->initialFilter($classList, $mockMethod, $array);
        
        $this->stub->expects($this->exactly(1))
        ->method('renderView')
        ->willReturn(true);
        
        $result = $this->stub->filter();

        $this->assertTrue($result);
    }

    protected function filterFailure($classList, $mockMethod, $array)
    {
        $this->initialFilter($classList, $mockMethod, $array);
        
        $this->stub->expects($this->exactly(1))
        ->method('displayError')
        ->willReturn(false);
        
        $result = $this->stub->filter();

        $this->assertFalse($result);
    }
}
