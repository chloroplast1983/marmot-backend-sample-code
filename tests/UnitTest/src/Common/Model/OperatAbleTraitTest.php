<?php
namespace Common\Model;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class OperatAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockOperatAbleTrait::class)
                            ->setMethods(['addAction', 'editAction'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    public function testAdd()
    {
        $this->trait->expects($this->exactly(1))
                    ->method('addAction')
                    ->willReturn(true);

        $result = $this->trait->add();
        $this->assertTrue($result);
    }

    public function testEdit()
    {
        $this->trait->expects($this->exactly(1))
                    ->method('editAction')
                    ->willReturn(true);

        $result = $this->trait->edit();
        $this->assertTrue($result);
    }
}
