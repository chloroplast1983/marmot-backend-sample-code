<?php
namespace UserGroup\Translator;

use PHPUnit\Framework\TestCase;

use UserGroup\Utils\UserGroupUtils;

class UserGroupDBTranslatorTest extends TestCase
{
    use UserGroupUtils;

    private $translator;

    public function setUp()
    {
        $this->translator = new UserGroupDBTranslator();
    }

    public function tearDown()
    {
        unset($this->translator);
    }

    public function testImplementsITranslator()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Interfaces\ITranslator',
            $this->translator
        );
    }

    public function testArrayToObjectIncorrectArray()
    {
        $result = $this->translator->arrayToObject(array());
        $this->assertInstanceOf('UserGroup\Model\NullUserGroup', $result);
    }

    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->translator->objectToArray(null);
        $this->assertFalse($result);
    }

    public function testArrayToObject()
    {
        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup(1);

        $expression['usergroup_id'] = $userGroup->getId();
        $expression['name'] = $userGroup->getName();
        $expression['status'] = $userGroup->getStatus();
        $expression['status_time'] = $userGroup->getStatusTime();
        $expression['create_time'] = $userGroup->getCreateTime();
        $expression['update_time'] = $userGroup->getUpdateTime();

        $userGroup = $this->translator->arrayToObject($expression);
        $this->assertInstanceof('UserGroup\Model\UserGroup', $userGroup);
        $this->compareArrayAndObject($expression, $userGroup);
    }

    public function testObjectToArray()
    {
        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup(1);

        $expression = $this->translator->objectToArray($userGroup);

        $this->compareArrayAndObject($expression, $userGroup);
    }
}
