<?php
namespace UserGroup\Model;

use PHPUnit\Framework\TestCase;

class NullUserGroupTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new NullUserGroup();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsUserGroup()
    {
        $this->assertInstanceof('UserGroup\Model\UserGroup', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
