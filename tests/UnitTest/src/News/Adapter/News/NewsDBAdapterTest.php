<?php
namespace News\Adapter\News;

use Marmot\Core;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use News\Utils\ObjectGenerate;
use News\Translator\NewsDBTranslator;
use News\Adapter\News\Query\NewsRowCacheQuery;

use UserGroup\Model\UserGroup;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class NewsDBAdapterTest extends TestCase
{
    private $translator;

    private $rowCacheQuery;

    private $contentDocumentAdapter;

    private $userGroupRepository;
    
    private $adapter;

    public function setUp()
    {
        $this->adapter = $this->getMockBuilder(TestNewsDBAdapter::class)
                        ->setMethods(['formatSort'])
                        ->getMock();

        $this->translator = $this->prophesize(NewsDBTranslator::class);
        $this->rowCacheQuery = $this->prophesize(NewsRowCacheQuery::class);
        $this->contentDocumentAdapter = $this->prophesize(ContentDocumentAdapter::class);
        $this->userGroupRepository = $this->prophesize(UserGroupRepository::class);
    }

    public function tearDown()
    {
        unset($this->adapter);
        unset($this->translator);
        unset($this->rowCacheQuery);
        unset($this->contentDocumentAdapter);
        unset($this->userGroupRepository);
    }

    public function testGetDBTranslator()
    {
        $this->assertInstanceOf(
            'News\Translator\NewsDBTranslator',
            $this->adapter->getDBTranslator()
        );
    }

    public function testGetRowCacheQuery()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\Query\NewsRowCacheQuery',
            $this->adapter->getRowCacheQuery()
        );
    }

    public function testGetContentDocumentAdapter()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\ContentDocumentAdapter',
            $this->adapter->getContentDocumentAdapter()
        );
    }

    public function testGetUserGroupRepository()
    {
        $this->assertInstanceOf(
            'UserGroup\Repository\UserGroup\UserGroupRepository',
            $this->adapter->getUserGroupRepository()
        );
    }

    public function testFetchOneFailure()
    {
        $adapter = $this->getMockBuilder(TestNewsDBAdapter::class)
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
        $this->assertInstanceOf('News\Model\NullNews', $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
  
    public function testFetchOneSuccess()
    {
        $adapter = $this->getMockBuilder(TestNewsDBAdapter::class)
                ->setMethods([
                    'getRowCacheQuery',
                    'getDBTranslator',
                    'getContentDocumentAdapter',
                    'fetchPublishUserGroupByNews'
                ])->getMock();

        $id = 1;
        $info = array('info');
        $news = ObjectGenerate::generateNews($id);
        $content = '需求内容';

        $this->rowCacheQuery->getOne(Argument::exact($id))
                                          ->shouldBeCalledTimes(1)
                                          ->willReturn($info);

        $this->translator->arrayToObject(Argument::exact($info))
                                         ->shouldBeCalledTimes(1)
                                         ->willReturn($news);

        $this->contentDocumentAdapter->fetchOne(Argument::exact($news->getContent()))
                                            ->shouldBeCalledTimes(1)
                                            ->willReturn($content);
        $adapter->expects($this->exactly(1))
                ->method('getContentDocumentAdapter')
                ->willReturn($this->contentDocumentAdapter->reveal());

        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup($news->getPublishUserGroup()->getId());

        $adapter->expects($this->exactly(1))
                ->method('fetchPublishUserGroupByNews')
                ->with($news)
                ->willReturn($userGroup);
       
        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());
        $adapter->expects($this->exactly(1))
                ->method('getDBTranslator')
                ->willReturn($this->translator->reveal());
        $adapter->expects($this->exactly(1))
                ->method('getContentDocumentAdapter')
                ->willReturn($this->contentDocumentAdapter->reveal());

        $result = $adapter->fetchOne($id);
        $this->assertEquals($result, $news);
    }

    public function testFetchListFail()
    {
        $adapter = $this->getMockBuilder(NewsDBAdapter::class)
                        ->setMethods(['getRowCacheQuery'])
                        ->getMock();
                        
        $ids = [1, 2];
        $newsList = array();

        $this->rowCacheQuery->getList(Argument::exact($ids))
                            ->shouldBeCalledTimes(1)
                            ->willReturn($newsList);

        $adapter->expects($this->exactly(1))
                ->method('getRowCacheQuery')
                ->willReturn($this->rowCacheQuery->reveal());

        $result = $adapter->fetchList($ids);
        $this->assertEquals([], $result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
