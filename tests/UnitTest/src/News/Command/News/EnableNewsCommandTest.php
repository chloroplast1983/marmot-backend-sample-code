<?php
namespace News\Command\News;

use PHPUnit\Framework\TestCase;

class EnableNewsCommandTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new EnableNewsCommand(1);
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsEnableCommand()
    {
        $this->assertInstanceof('Common\Command\EnableCommand', $this->stub);
    }
}
