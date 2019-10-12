<?php
namespace Member\Model;

use Marmot\Core;

use Member\Repository\Member\MemberRepository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Common\Model\IEnableAble;

class MemberTest extends TestCase
{
    private $member;

    private $childMember;

    public function setUp()
    {
        $this->member = new Member();
        $this->childMember = new class extends Member{
            public function getRepository() : MemberRepository
            {
                return parent::getRepository();
            }
        };
    }

    public function tearDown()
    {
        parent::tearDown();
        Core::setLastError(ERROR_NOT_DEFINED);
        unset($this->member);
    }

    public function testMemberConstructor()
    {
        $this->assertEquals('', $this->member->getCellphone());
        $this->assertEquals('', $this->member->getUserName());
        $this->assertEquals('', $this->member->getRealName());
        $this->assertEquals('', $this->member->getCardId());
        $this->assertEquals(array(), $this->member->getAvatar());
        $this->assertEquals(IEnableAble::STATUS['ENABLED'], $this->member->getStatus());
    }
    
    //cellphone 测试 ---------------------------------------------------- start
    /**
     * 设置 Member setCellphone() 正确的传参类型,期望传值正确
     */
    public function testSetCellphoneCorrectType()
    {
        $this->member->setCellphone('string');
        $this->assertEquals('string', $this->member->getCellphone());
    }

    /**
     * 设置 Member setCellphone() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCellphoneWrongType()
    {
        $this->member->setCellphone(array(1,2,3));
    }
    //cellphone 测试 ----------------------------------------------------   end\
    
    //userName 测试 ---------------------------------------------------- start
    /**
     * 设置 Member setUserName() 正确的传参类型,期望传值正确
     */
    public function testSetUserNameCorrectType()
    {
        $this->member->setUserName('string');
        $this->assertEquals('string', $this->member->getUserName());
    }

    /**
     * 设置 Member setUserName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetUserNameWrongType()
    {
        $this->member->setUserName(array(1,2,3));
    }
    //userName 测试 ----------------------------------------------------   end

    //realName 测试 ---------------------------------------------------- start
    /**
     * 设置 Member setRealName() 正确的传参类型,期望传值正确
     */
    public function testSetRealNameCorrectType()
    {
        $this->member->setRealName('string');
        $this->assertEquals('string', $this->member->getRealName());
    }

    /**
     * 设置 Member setRealName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRealNameWrongType()
    {
        $this->member->setRealName(array(1,2,3));
    }
    //realName 测试 ----------------------------------------------------   end
    
    //cardId 测试 ---------------------------------------------------- start
    /**
     * 设置 Member setCardId() 正确的传参类型,期望传值正确
     */
    public function testSetCardIdCorrectType()
    {
        $this->member->setCardId('string');
        $this->assertEquals('string', $this->member->getCardId());
    }

    /**
     * 设置 Member setCardId() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCardIdWrongType()
    {
        $this->member->setCardId(array(1,2,3));
    }
    //cardId 测试 ----------------------------------------------------   end

    //avatar 测试 ---------------------------------------------------- start
    /**
     * 设置 Member setAvatar() 正确的传参类型,期望传值正确
     */
    public function testSetAvatarCorrectType()
    {
        $this->member->setAvatar(array('avatar'));
        $this->assertEquals(array('avatar'), $this->member->getAvatar());
    }

    /**
     * 设置 Member setAvatar() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAvatarWrongType()
    {
        $this->member->setAvatar(1);
    }
    //avatar 测试 ----------------------------------------------------   end

    public function testGetRepository()
    {
        $this->assertInstanceof(
            'Member\Repository\Member\MemberRepository',
            $this->childMember->getRepository()
        );
    }
}
