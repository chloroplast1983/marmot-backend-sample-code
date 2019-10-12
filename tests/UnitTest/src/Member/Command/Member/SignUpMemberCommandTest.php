<?php
namespace Member\Command\Member;

use PHPUnit\Framework\TestCase;

class SignUpMemberCommandTest extends TestCase
{
    private $fakerData = array();

    private $stub;

    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'cellphone' => $faker->phoneNumber(),
            'password' => $faker->password(),
            'id' => $faker->randomNumber(),
        );

        $this->stub = new SignUpMemberCommand(
            $this->fakerData['cellphone'],
            $this->fakerData['password'],
            $this->fakerData['id']
        );
    }

    public function testCorrectInstanceExtendsCommand()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\ICommand',
            $this->stub
        );
    }

    public function testCellphoneParameter()
    {
        $this->assertEquals($this->fakerData['cellphone'], $this->stub->cellphone);
    }

    public function testPasswordParameter()
    {
        $this->assertEquals($this->fakerData['password'], $this->stub->password);
    }
}
