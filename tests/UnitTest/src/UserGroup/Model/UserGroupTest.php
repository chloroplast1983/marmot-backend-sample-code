<?php
namespace UserGroup\Model;

use Marmot\Core;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

class UserGroupTest extends TestCase
{
    private $stub;

    private $faker;

    public function setUp()
    {
        $this->stub = new UserGroup();

        $this->faker = \Faker\Factory::create();
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->faker);
    }

    public function testCorrectImplementsIObject()
    {
        $model = new UserGroup();
        $this->assertInstanceof('Marmot\Common\Model\IObject', $model);
    }

    public function testUserGroupConstructor()
    {
        $this->assertEquals(0, $this->stub->getId());
        $this->assertEmpty($this->stub->getName());
        $this->assertEquals(UserGroup::STATUS_NORMAL, $this->stub->getStatus());
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $id = $this->faker->randomNumber();

        $this->stub->setId($id);
        $this->assertEquals($id, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //name 测试 ---------------------------------------------------- start
    /**
     * 设置 setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $name = $this->faker->name();

        $this->stub->setName($name);
        $this->assertEquals($name, $this->stub->getName());
    }

    /**
     * 设置 setName() 错误的传参类型, 期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $name = array($this->faker->randomNumber());

        $this->stub->setName($name);
    }
    //name 测试 ----------------------------------------------------   end
    
    //status 测试 ---------------------------------------------------- start
    /**
     * 设置 setStatus() 正确的传参类型,期望传值正确
     */
    public function testSetStatusCorrectType()
    {
        $status = UserGroup::STATUS_NORMAL;

        $this->stub->setStatus($status);
        $this->assertEquals($status, $this->stub->getStatus());
    }

    /**
     * 设置 setStatus() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetStatusWrongType()
    {
        $status = $this->faker->name();

        $this->stub->setStatus($status);
    }
    //status 测试 ----------------------------------------------------   end
}
