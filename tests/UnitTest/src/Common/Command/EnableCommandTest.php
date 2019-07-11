<?php
namespace Common\Command;

use PHPUnit\Framework\TestCase;

class EnableCommandTest extends TestCase
{
    public function testId()
    {
        $command = $this->getMockBuilder(EnableCommand::class)
                        ->setConstructorArgs(array(1))
                        ->getMock();

        $this->assertEquals(1, $command->id);
    }
}
