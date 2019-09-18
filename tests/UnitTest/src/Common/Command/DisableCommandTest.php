<?php
namespace Common\Command;

use PHPUnit\Framework\TestCase;

class DisableCommandTest extends TestCase
{
    public function testId()
    {
        $command = $this->getMockBuilder(DisableCommand::class)
                        ->setConstructorArgs(array(1))
                        ->getMock();

        $this->assertEquals(1, $command->id);
    }
}
