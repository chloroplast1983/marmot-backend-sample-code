<?php
namespace News\Model;

use Marmot\Core;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Model\IEnableAble;

use News\Repository\News\NewsRepository;
use News\Adapter\News\ContentDocumentAdapter;

use UserGroup\Model\UserGroup;

class NewsTest extends TestCase
{
    private $stub;

    private $faker;

    public function setUp()
    {
        $this->stub = new TestNews();

        $this->faker = \Faker\Factory::create();
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->faker);
    }

    public function testCorrectImplementsIEnableAble()
    {
        $model = new News();
        $this->assertInstanceof('Common\Model\IEnableAble', $model);
    }

    public function testCorrectImplementsIOperatAble()
    {
        $model = new News();
        $this->assertInstanceof('Common\Model\IOperatAble', $model);
    }

    public function testCorrectImplementsIObject()
    {
        $model = new News();
        $this->assertInstanceof('Marmot\Common\Model\IObject', $model);
    }

    public function testNewsConstructor()
    {
        $this->assertEquals(0, $this->stub->getId());
        $this->assertEmpty($this->stub->getTitle());
        $this->assertEmpty($this->stub->getSource());
        $this->assertEquals(array(), $this->stub->getImage());
        $this->assertEquals(array(), $this->stub->getAttachments());
        $this->assertEquals(IEnableAble::STATUS['ENABLED'], $this->stub->getStatus());
        $this->assertInstanceOf(
            'UserGroup\Model\UserGroup',
            $this->stub->getPublishUserGroup()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $id = $this->faker->randomNumber();

        $this->stub->setId($id);
        $this->assertEquals($id, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //title 测试 ------------------------------------------------------- start
    /**
     * 设置 Service setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $title = $this->faker->title();

        $this->stub->setTitle($title);
        $this->assertEquals($title, $this->stub->getTitle());
    }

    /**
     * 设置 Service setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1,2,3));
    }
    //title 测试 -------------------------------------------------------   end
    
    //source 测试 ------------------------------------------------------ start
    /**
     * 设置 Journal setSource() 正确的传参类型,期望传值正确
     */
    public function testSetSourceCorrectType()
    {
        $this->stub->setSource('string');
        $this->assertEquals('string', $this->stub->getSource());
    }

    /**
     * 设置 Journal setSource() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetSourceWrongType()
    {
        $this->stub->setSource(array(1, 2, 3));
    }
    //source 测试 ------------------------------------------------------   end
    
    //image 测试 ------------------------------------------------- start
    public function testSetImageCorrectType()
    {
        $this->stub->setImage(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getImage());
    }

    /**
     * @expectedException TypeError
     */
    public function testSetImageWrongType()
    {
        $this->stub->setImage(1);
    }
    //image 测试 -------------------------------------------------   end

    //attachments 测试 ------------------------------------------------- start
    public function testSetAttachmentsCorrectType()
    {
        $this->stub->setAttachments(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getAttachments());
    }

    /**
     * @expectedException TypeError
     */
    public function testSetAttachmentsWrongType()
    {
        $this->stub->setAttachments(1);
    }
    //attachments 测试 -------------------------------------------------   end
    
    //content 测试 ------------------------------------------------------ start
    /**
     * 设置 setContent() 正确的传参类型,期望传值正确
     */
    public function testSetContentCorrectType()
    {
        $object = new ContentDocument();
        $this->stub->setContent($object);
        $this->assertSame($object, $this->stub->getContent());
    }

    /**
     * 设置 setContent() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContentWrongType()
    {
        $this->stub->setContent('string');
    }
    //content 测试 ------------------------------------------------------   end
    
    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'News\Repository\News\NewsRepository',
            $this->stub->getRepository()
        );
    }

    public function testGetContentDocumentAdapter()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\ContentDocumentAdapter',
            $this->stub->getContentDocumentAdapter()
        );
    }

    private function initialContentDocument($result)
    {
        $adapter = $this->prophesize(ContentDocumentAdapter::class);

        $adapter->add(Argument::exact($this->stub->getContent()))->shouldBeCalledTimes(1)->willReturn($result);

        $this->stub->expects($this->any())
                   ->method('getContentDocumentAdapter')
                   ->willReturn($adapter->reveal());
    }

    public function testAddActionFailure()
    {
        $this->stub = $this->getMockBuilder(TestNews::class)
                    ->setMethods(['getContentDocumentAdapter'])
                    ->getMock();

        $this->initialContentDocument(false);

        $result = $this->stub->addAction();

        $this->assertFalse($result);
    }

    public function testAddActionSuccess()
    {
        $this->stub = $this->getMockBuilder(TestNews::class)
                    ->setMethods(['getRepository', 'getContentDocumentAdapter'])
                    ->getMock();

        $this->initialContentDocument(true);
        
        $repository = $this->prophesize(NewsRepository::class);

        $repository->add(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->any())
                   ->method('getRepository')
                   ->willReturn($repository->reveal());

        $result = $this->stub->addAction();

        $this->assertTrue($result);
    }

    public function testEditActionFailure()
    {
        $this->stub = $this->getMockBuilder(TestNews::class)
                    ->setMethods(['getContentDocumentAdapter'])
                    ->getMock();

        $this->initialContentDocument(false);

        $result = $this->stub->editAction();

        $this->assertFalse($result);
    }

    public function testEditActionSuccess()
    {
        $this->stub = $this->getMockBuilder(TestNews::class)
                    ->setMethods(['getRepository', 'getContentDocumentAdapter'])
                    ->getMock();

        $this->initialContentDocument(true);
        
        $this->stub->setUpdateTime(Core::$container->get('time'));

        $repository = $this->prophesize(NewsRepository::class);

        $repository->edit(
            Argument::exact($this->stub),
            array(
                'title',
                'source',
                'image',
                'attachments',
                'content',
                'updateTime'
            )
        )->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->once())
                   ->method('getRepository')
                   ->willReturn($repository->reveal());

        $result = $this->stub->editAction();

        $this->assertTrue($result);
    }

    public function testUpdateStatus()
    {
        $this->stub = $this->getMockBuilder(TestNews::class)
            ->setMethods(['getRepository'])
            ->getMock();

        $status = IEnableAble::STATUS['ENABLED'];
        $this->stub->setStatus($status);
        $this->stub->setUpdateTime(Core::$container->get('time'));
        $this->stub->setStatusTime(Core::$container->get('time'));

        $repository = $this->prophesize(NewsRepository::class);

        $repository->edit(
            Argument::exact($this->stub),
            Argument::exact(array(
                'statusTime',
                'status',
                'updateTime'
            ))
        )->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->any())
                   ->method('getRepository')
                   ->willReturn($repository->reveal());

        $result = $this->stub->updateStatus($status);
        
        $this->assertTrue($result);
    }
}
