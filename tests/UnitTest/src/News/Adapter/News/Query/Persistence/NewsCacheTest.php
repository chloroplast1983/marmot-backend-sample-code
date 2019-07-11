<?php
namespace News\Adapter\News\Query\Persistence;

use PHPUnit\Framework\TestCase;

class NewsCacheTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new NewsCache();
    }

    public function testCorrectInstanceExtendsCache()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Cache', $this->stub);
    }
}
