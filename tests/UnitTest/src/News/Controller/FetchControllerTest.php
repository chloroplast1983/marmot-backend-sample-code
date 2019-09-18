<?php
namespace News\Controller;

use PHPUnit\Framework\TestCase;

use Utility\ControllerTestCase;

use News\Model\NullNews;
use News\Utils\ObjectGenerate;
use News\Repository\News\NewsRepository;

class FetchControllerTest extends ControllerTestCase
{
    private $childStub;

    public function setUp()
    {
        $this->stub = new FetchController();

        $this->childStub = new class extends FetchController
        {
            public function getRepository() : NewsRepository
            {
                return parent::getRepository();
            }
        };
    }

    public function teatDown()
    {
        unset($this->childStub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'News\Repository\News\NewsRepository',
            $this->childStub->getRepository()
        );
    }

    public function testFetchOneSuccess()
    {
        $news = ObjectGenerate::generateNews(1);

        $this->fetchOneSuccess(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $news
        );
    }

    public function testFetchOneFailure()
    {
        $news = new NullNews();

        $this->fetchOneFailure(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $news
        );
    }

    public function testFetchListSuccess()
    {
        $newsArray = array(
            ObjectGenerate::generateNews(1)
        );

        $this->fetchListSuccess(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $newsArray
        );
    }

    public function testFetchListFailure()
    {
        $newsArray = array();

        $this->fetchListFailure(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $newsArray
        );
    }

    public function testFilterSuccess()
    {
        $newsArray = array(
            array(ObjectGenerate::generateNews(1)),
            1
        );

        $this->filterSuccess(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $newsArray
        );
    }

    public function testFilterFailure()
    {
        $newsArray = array(array(), 0);

        $this->filterFailure(
            [
                'repository'=>NewsRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $newsArray
        );
    }
}
