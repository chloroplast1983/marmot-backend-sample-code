<?php
namespace Member\Adapter\Member;

use Marmot\Core;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Member\Utils\MockFactory;
use Member\Translator\MemberDBTranslator;
use Member\Adapter\Member\Query\MemberRowCacheQuery;

class MemberDBAdapterTest extends TestCase
{
    private $translator;

    private $rowCacheQuery;
    
    private $adapter;

    public function setUp()
    {
        $this->adapter = $this->getMockBuilder(TestMemberDBAdapter::class)
                        ->setMethods(['formatSort'])
                        ->getMock();

        $this->translator = $this->prophesize(MemberDBTranslator::class);
        $this->rowCacheQuery = $this->prophesize(MemberRowCacheQuery::class);
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
            'Member\Translator\MemberDBTranslator',
            $this->adapter->getDBTranslator()
        );
    }

    public function testGetRowCacheQuery()
    {
        $this->assertInstanceOf(
            'Member\Adapter\Member\Query\MemberRowCacheQuery',
            $this->adapter->getRowCacheQuery()
        );
    }
    
    public function testFetchOneFailure()
    {
        $adapter = $this->getMockBuilder(TestMemberDBAdapter::class)
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
        $this->assertInstanceOf('Member\Model\NullMember', $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
  
    public function testFetchOneSuccess()
    {
        $adapter = $this->getMockBuilder(TestMemberDBAdapter::class)
                ->setMethods([
                    'getRowCacheQuery',
                    'getDBTranslator',
                ])->getMock();

        $id = 1;
        $info = array('info');
        $member = MockFactory::generateMember($id);

        $this->rowCacheQuery->getOne(Argument::exact($id))
                                          ->shouldBeCalledTimes(1)
                                          ->willReturn($info);

        $this->translator->arrayToObject(Argument::exact($info))
                                         ->shouldBeCalledTimes(1)
                                         ->willReturn($member);
       
        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());
        $adapter->expects($this->exactly(1))
                ->method('getDBTranslator')
                ->willReturn($this->translator->reveal());

        $result = $adapter->fetchOne($id);
        $this->assertEquals($result, $member);
    }

    public function testFetchListFail()
    {
        $adapter = $this->getMockBuilder(MemberDBAdapter::class)
                        ->setMethods(['getRowCacheQuery'])
                        ->getMock();
                        
        $ids = [1, 2];
        $memberList = array();

        $this->rowCacheQuery->getList(Argument::exact($ids))
                            ->shouldBeCalledTimes(1)
                            ->willReturn($memberList);

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());

        $result = $adapter->fetchList($ids);
        $this->assertEquals([], $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
