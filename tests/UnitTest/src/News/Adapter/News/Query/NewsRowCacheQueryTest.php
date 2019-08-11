<?php
namespace News\Adapter\News\Query;

use PHPUnit\Framework\TestCase;

use Marmot\Framework\Interfaces\DbLayer;
use Marmot\Framework\Interfaces\CacheLayer;

class NewsRowCacheQueryTest extends TestCase
{
    private $rowCacheQuery;

    public function setUp()
    {
        $this->rowCacheQuery = new class extends NewsRowCacheQuery
        {
            public function getCacheLayer() : CacheLayer
            {
                return parent::getCacheLayer();
            }

            public function getDbLayer() : DbLayer
            {
                return parent::getDbLayer();
            }
        };
    }

    public function testCorrectInstanceExtendsRowCacheQuery()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\Query\NewsRowCacheQuery',
            $this->rowCacheQuery
        );
    }

    public function testCorrectCacheLayer()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\Query\Persistence\NewsCache',
            $this->rowCacheQuery->getCacheLayer()
        );
    }

    public function testCorrectDbLayer()
    {
        $this->assertInstanceOf(
            'News\Adapter\News\Query\Persistence\NewsDb',
            $this->rowCacheQuery->getDbLayer()
        );
    }
}
