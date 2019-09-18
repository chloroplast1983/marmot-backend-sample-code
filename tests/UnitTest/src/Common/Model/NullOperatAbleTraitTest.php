<?php
namespace Common\Model;

use PHPUnit\Framework\TestCase;

class NullOperatAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockNullOperatAbleTrait::class)
                            ->setMethods(['resourceNotExist'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    public function testAdd()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->add();
        $this->assertFalse($result);
    }

    public function testEdit()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->edit();
        $this->assertFalse($result);
    }

    public function testAddAction()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->addAction();
        $this->assertFalse($result);
    }

    public function testEditAction()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->editAction();
        $this->assertFalse($result);
    }

    private function mockResourceNotExist()
    {
        $this->trait->expects($this->exactly(1))
                    ->method('resourceNotExist')
                    ->willReturn(false);
    }
}
