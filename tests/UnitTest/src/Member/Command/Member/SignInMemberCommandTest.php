<?php
namespace Member\Command\Member;

use PHPUnit\Framework\TestCase;

class SignInMemberCommandTest extends TestCase
{
    private $fakerData = array();

    private $stub;

    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'passport' => $faker->phoneNumber(),
            'password' => $faker->password(),
            'id' => $faker->randomNumber(),
        );

        $this->stub = new SignInMemberCommand(
            $this->fakerData['passport'],
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

    public function testPassportParameter()
    {
        $this->assertEquals($this->fakerData['passport'], $this->stub->passport);
    }

    public function testPasswordParameter()
    {
        $this->assertEquals($this->fakerData['password'], $this->stub->password);
    }
}
