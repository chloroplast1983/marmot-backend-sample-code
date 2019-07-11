<?php
namespace UserGroup\Adapter\UserGroup\Query;

use Marmot\Framework\Interfaces\DbLayer;
use Marmot\Framework\Interfaces\CacheLayer;

use PHPUnit\Framework\TestCase;

class UserGroupRowCacheQueryTest extends TestCase
{
    private $rowCacheQuery;

    public function setUp()
    {
        $this->rowCacheQuery = new class extends UserGroupRowCacheQuery
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
            'UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery',
            $this->rowCacheQuery
        );
    }

    public function testCorrectCacheLayer()
    {
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\Query\Persistence\UserGroupCache',
            $this->rowCacheQuery->getCacheLayer()
        );
    }

    public function testCorrectDbLayer()
    {
        $this->assertInstanceOf(
            'UserGroup\Adapter\UserGroup\Query\Persistence\UserGroupDb',
            $this->rowCacheQuery->getDbLayer()
        );
    }
}
