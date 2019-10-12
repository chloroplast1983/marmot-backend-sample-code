<?php
namespace Member\Adapter\Member\Query;

use PHPUnit\Framework\TestCase;

use Marmot\Framework\Interfaces\DbLayer;
use Marmot\Interfaces\CacheLayer;

class MemberRowCacheQueryTest extends TestCase
{
    private $rowCacheQuery;

    public function setUp()
    {
        $this->rowCacheQuery = new class extends MemberRowCacheQuery
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
            'Member\Adapter\Member\Query\MemberRowCacheQuery',
            $this->rowCacheQuery
        );
    }

    public function testCorrectCacheLayer()
    {
        $this->assertInstanceOf(
            'Member\Adapter\Member\Query\Persistence\MemberCache',
            $this->rowCacheQuery->getCacheLayer()
        );
    }

    public function testCorrectDbLayer()
    {
        $this->assertInstanceOf(
            'Member\Adapter\Member\Query\Persistence\MemberDb',
            $this->rowCacheQuery->getDbLayer()
        );
    }
}
