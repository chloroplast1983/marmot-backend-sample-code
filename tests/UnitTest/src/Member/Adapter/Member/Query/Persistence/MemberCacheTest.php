<?php
namespace Member\Adapter\Member\Query\Persistence;

use PHPUnit\Framework\TestCase;

class MemberCacheTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new MemberCache();
    }

    public function testCorrectInstanceExtendsCache()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Cache', $this->stub);
    }
}
