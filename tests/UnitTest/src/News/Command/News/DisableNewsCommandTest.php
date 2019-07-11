<?php
namespace News\Command\News;

use PHPUnit\Framework\TestCase;

class DisableNewsCommandTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new DisableNewsCommand(1);
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsDisableCommand()
    {
        $this->assertInstanceof('Common\Command\DisableCommand', $this->stub);
    }
}
