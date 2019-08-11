<?php
namespace News\Model;

use PHPUnit\Framework\TestCase;

class NullNewsTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new NullNews();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsNews()
    {
        $this->assertInstanceof('News\Model\News', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Framework\Interfaces\INull', $this->stub);
    }
}
