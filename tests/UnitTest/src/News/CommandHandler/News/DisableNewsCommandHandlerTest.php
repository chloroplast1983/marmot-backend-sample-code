<?php
namespace News\CommandHandler\News;

use PHPUnit\Framework\TestCase;

class DisableNewsCommandHandlerTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new TestDisableNewsCommandHandler();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsCommandHandler()
    {
        $this->assertInstanceOf(
            'Common\CommandHandler\DisableCommandHandler',
            $this->stub
        );
    }

    public function testFetchIEnableObject()
    {
        $this->stub = $this->getMockBuilder(TestDisableNewsCommandHandler::class)
                           ->setMethods([
                               'fetchNews'
                            ])->getMock();

        $id = 1;
        $news = \News\Utils\ObjectGenerate::generateNews($id);

        $this->stub->expects($this->once())
            ->method('fetchNews')
            ->willReturn($news);

        $result = $this->stub->fetchIEnableObject($id);
     
        $this->assertEquals($result, $news);
    }
}
