<?php
namespace Member\Adapter\Member\Query\Persistence;

use PHPUnit\Framework\TestCase;

class MemberDbTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new MemberDb();
    }

    public function testCorrectInstanceExtendsDb()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Db', $this->stub);
    }
}
