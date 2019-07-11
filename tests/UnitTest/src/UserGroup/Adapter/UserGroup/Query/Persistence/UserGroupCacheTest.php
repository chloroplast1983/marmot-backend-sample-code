<?php
namespace UserGroup\Adapter\UserGroup\Query\Persistence;

use PHPUnit\Framework\TestCase;

class UserGroupCacheTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserGroupCache();
    }

    public function testCorrectInstanceExtendsCache()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Cache', $this->stub);
    }
}
