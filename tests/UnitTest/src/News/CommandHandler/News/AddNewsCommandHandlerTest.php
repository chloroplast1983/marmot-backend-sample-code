<?php
namespace News\CommandHandler\News;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Interfaces\ICommand;

use News\Model\News;
use News\Model\ContentDocument;
use News\Command\News\AddNewsCommand;

use UserGroup\Model\UserGroup;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class AddNewsCommandHandlerTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = new AddNewsCommandHandler();

        $this->childStub = new class extends AddNewsCommandHandler
        {
            public function getNews() : News
            {
                return parent::getNews();
            }
            public function getUserGroupRepository() : UserGroupRepository
            {
                return parent::getUserGroupRepository();
            }
            public function getContentDocument() : ContentDocument
            {
                return parent::getContentDocument();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testCorrectInstanceImplementCommandHandler()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ICommandHandler',
            $this->stub
        );
    }

    public function testGetNews()
    {
        $this->assertInstanceOf(
            'News\Model\News',
            $this->childStub->getNews()
        );
    }

    public function testGetUserGroupRepository()
    {
        $this->assertInstanceOf(
            'UserGroup\Repository\UserGroup\UserGroupRepository',
            $this->childStub->getUserGroupRepository()
        );
    }

    public function testGetContentDocument()
    {
        $this->assertInstanceOf(
            'News\Model\ContentDocument',
            $this->childStub->getContentDocument()
        );
    }
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $command = new class implements ICommand{
        };
        $this->stub->execute($command);
    }

    public function initialExecute($result)
    {
        $this->stub = $this->getMockBuilder(AddNewsCommandHandler::class)
                           ->setMethods([
                               'getNews',
                               'getUserGroupRepository',
                               'getContentDocument'
                            ])->getMock();

        $faker = \Faker\Factory::create('zh_CN');

        $title = $faker->title();
        $content = $faker->text();
        $source = $faker->title();
        $image = array($faker->title());
        $attachments = array($faker->title());
        $publishUserGroupId = $faker->randomDigit;
        $id = $faker->randomDigit;

        $command = new AddNewsCommand(
            $title,
            $source,
            $image,
            $attachments,
            $content,
            $publishUserGroupId
        );
        
        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup($publishUserGroupId);
       
        $userGroupRepository = $this->prophesize(UserGroupRepository::class);
        $userGroupRepository->fetchOne(Argument::exact($publishUserGroupId))
                             ->shouldBeCalledTimes(1)->willReturn($userGroup);
        $this->stub->expects($this->exactly(1))
                   ->method('getUserGroupRepository')
                   ->willReturn($userGroupRepository->reveal());

        $contentDocument = $this->prophesize(ContentDocument::class);
        $contentDocument->setData(Argument::exact(array('content'=>$content)))->shouldBeCalledTimes(1);
        $this->stub->expects($this->exactly(1))
                   ->method('getContentDocument')
                   ->willReturn($contentDocument->reveal());

        $news = $this->prophesize(News::class);

        $news->setTitle(Argument::exact($title))->shouldBeCalledTimes(1);
        $news->setSource(Argument::exact($source))->shouldBeCalledTimes(1);
        $news->setImage(Argument::exact($image))->shouldBeCalledTimes(1);
        $news->setAttachments(Argument::exact($attachments))->shouldBeCalledTimes(1);
        $news->setPublishUserGroup(Argument::exact($userGroup))->shouldBeCalledTimes(1);
        $news->setContent(Argument::exact($contentDocument))->shouldBeCalledTimes(1);
        $news->add()->shouldBeCalledTimes(1)->willReturn($result);
        
        if ($result) {
            $news->getId()
                           ->shouldBeCalledTimes(1)
                           ->willReturn($id);
        }

        $this->stub->expects($this->exactly(1))
                   ->method('getNews')
                   ->willReturn($news->reveal());
                   
        return $command;
    }

    public function testExecuteSuccess()
    {
        $command = $this->initialExecute(true);
        $result = $this->stub->execute($command);
        $this->assertTrue($result);
    }

    public function testExecuteFailure()
    {
        $command = $this->initialExecute(false);
        $result = $this->stub->execute($command);
        $this->assertFalse($result);
    }
}
