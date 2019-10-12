<?php
namespace Member\Model;

use PHPUnit\Framework\TestCase;

use Marmot\Core;

class NullMemberTest extends TestCase
{
    private $nullMember;

    public function setUp()
    {
        $this->nullMember = new NullMember();
    }

    public function tearDown()
    {
        unset($this->nullMember);
    }

    public function testExtendsMember()
    {
        $this->assertInstanceof('Member\Model\Member', $this->nullMember);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->nullMember);
    }

    public function testSignUp()
    {
        $result = $this->nullMember->signUp();
        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
