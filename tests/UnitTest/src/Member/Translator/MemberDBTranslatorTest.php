<?php
namespace Member\Translator;

use PHPUnit\Framework\TestCase;

use Member\Utils\MemberUtils;

class MemberDBTranslatorTest extends TestCase
{
    use MemberUtils;

    private $translator;

    public function setUp()
    {
        $this->translator = new MemberDBTranslator();
    }

    public function tearDown()
    {
        unset($this->translator);
    }

    public function testImplementsITranslator()
    {
        $this->assertInstanceOf(
            'Marmot\Interfaces\ITranslator',
            $this->translator
        );
    }

    public function testArrayToObjectIncorrectArray()
    {
        $result = $this->translator->arrayToObject(array());
        $this->assertInstanceOf('Member\Model\NullMember', $result);
    }

    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertFalse($result);
    }

    public function testArrayToObject()
    {
        $member = \Member\Utils\MockFactory::generateMember(1);

        $expression['member_id'] = $member->getId();
        $expression['cellphone'] = $member->getCellphone();
        $expression['user_name'] = $member->getUserName();
        $expression['real_name'] = $member->getRealName();
        $expression['cardid'] = $member->getCardId();
        $expression['password'] = $member->getPassword();
        $expression['salt'] = $member->getSalt();
        $expression['avatar'] = json_encode($member->getAvatar());
        $expression['status'] = $member->getStatus();
        $expression['status_time'] = $member->getStatusTime();
        $expression['create_time'] = $member->getCreateTime();
        $expression['update_time'] = $member->getUpdateTime();

        $member = $this->translator->arrayToObject($expression);
        $this->assertInstanceof('Member\Model\Member', $member);
        $this->compareArrayAndObject($expression, $member);
    }

    public function testObjectToArray()
    {
        $member = \Member\Utils\MockFactory::generateMember(1);

        $expression = $this->translator->objectToArray($member);

        $this->compareArrayAndObject($expression, $member);
    }
}
