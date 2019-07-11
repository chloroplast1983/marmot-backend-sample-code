<?php
namespace News\Adapter\News\Query\Persistence;

use PHPUnit\Framework\TestCase;

class NewsDbTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new NewsDb();
    }

    public function testCorrectInstanceExtendsDb()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Db', $this->stub);
    }
}
