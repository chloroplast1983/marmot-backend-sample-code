<?php
namespace News\Translator;

use PHPUnit\Framework\TestCase;

use News\Utils\NewsUtils;

class NewsDBTranslatorTest extends TestCase
{
    use NewsUtils;

    private $translator;

    public function setUp()
    {
        $this->translator = new NewsDBTranslator();
    }

    public function tearDown()
    {
        unset($this->translator);
    }

    public function testImplementsITranslator()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ITranslator',
            $this->translator
        );
    }

    public function testArrayToObjectIncorrectArray()
    {
        $result = $this->translator->arrayToObject(array());
        $this->assertInstanceOf('News\Model\NullNews', $result);
    }

    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertFalse($result);
    }

    public function testArrayToObject()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $expression['news_id'] = $news->getId();
        $expression['title'] = $news->getTitle();
        $expression['source'] = $news->getSource();
        $expression['image'] = $news->getImage();
        $expression['attachments'] = $news->getAttachments();
        $expression['content'] = $news->getContent()->getId();
        $expression['publish_usergroup'] = $news->getPublishUserGroup()->getId();
        $expression['status'] = $news->getStatus();
        $expression['status_time'] = $news->getStatusTime();
        $expression['create_time'] = $news->getCreateTime();
        $expression['update_time'] = $news->getUpdateTime();

        $news = $this->translator->arrayToObject($expression);
        $this->assertInstanceof('News\Model\News', $news);
        $this->compareArrayAndObject($expression, $news);
    }

    public function testObjectToArray()
    {
        $news = \News\Utils\ObjectGenerate::generateNews(1);

        $expression = $this->translator->objectToArray($news);

        $this->compareArrayAndObject($expression, $news);
    }
}
