<?php
namespace News\CommandHandler\News;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Interfaces\ICommand;

use News\Model\News;
use News\Model\ContentDocument;
use News\Command\News\EditNewsCommand;

class EditNewsCommandHandlerTest extends TestCase
{
    private $editStub;

    private $childStub;

    public function setUp()
    {
        $this->editStub = new EditNewsCommandHandler();

        $this->childStub = new class extends AddNewsCommandHandler
        {
            public function getContentDocument() : ContentDocument
            {
                return parent::getContentDocument();
            }
        };
    }

    public function tearDown()
    {
        unset($this->editStub);
        unset($this->childStub);
    }

    public function testCorrectInstanceImplementCommandHandler()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ICommandHandler',
            $this->editStub
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
        $this->editStub->execute($command);
    }

    public function testExecute()
    {
        $this->editStub = $this->getMockBuilder(EditNewsCommandHandler::class)
                           ->setMethods(['fetchNews', 'getContentDocument'])
                           ->getMock();

        $faker = \Faker\Factory::create('zh_CN');
        $id = $faker->randomDigit;
        $newsObject = \News\Utils\ObjectGenerate::generateNews($id);

        $title = $newsObject->getTitle();
        $source = $newsObject->getSource();
        $image = $newsObject->getImage();
        $attachments = $newsObject->getAttachments();
        $content = $newsObject->getContent()->getId();

        $command = new EditNewsCommand(
            $title,
            $source,
            $image,
            $attachments,
            $content,
            $id
        );

        $contentDocument = $this->prophesize(ContentDocument::class);
        $contentDocument->setData(Argument::exact(array('content'=>$content)))->shouldBeCalledTimes(1);
        $this->editStub->expects($this->exactly(1))
                   ->method('getContentDocument')
                   ->willReturn($contentDocument->reveal());

        $news = $this->prophesize(News::class);
        $news->setTitle(Argument::exact($title))->shouldBeCalledTimes(1);
        $news->setSource(Argument::exact($source))->shouldBeCalledTimes(1);
        $news->setImage(Argument::exact($image))->shouldBeCalledTimes(1);
        $news->setAttachments(Argument::exact($attachments))->shouldBeCalledTimes(1);
        $news->setContent(Argument::exact($contentDocument))->shouldBeCalledTimes(1);
    
        $news->edit()->shouldBeCalledTimes(1)->willReturn(true);

        $this->editStub->expects($this->once())
            ->method('fetchNews')
            ->willReturn($news->reveal());

        $result = $this->editStub->execute($command);
        $this->assertTrue($result);
    }
}
