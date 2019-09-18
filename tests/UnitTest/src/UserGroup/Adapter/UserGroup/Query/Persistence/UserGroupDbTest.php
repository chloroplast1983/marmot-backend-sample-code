<?php
namespace UserGroup\Adapter\UserGroup\Query\Persistence;

use PHPUnit\Framework\TestCase;

class UserGroupDbTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserGroupDb();
    }

    public function testCorrectInstanceExtendsDb()
    {
        $this->assertInstanceof('Marmot\Framework\Classes\Db', $this->stub);
    }
}
