<?php
namespace Member\Utils;

use Member\Model\Member;
use Member\Model\ContentDocument;

use Common\Model\IEnableAble;

class MockFactory
{
    public static function generateMember(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : Member {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $member = new Member($id);

        $member->setId($id);

        //cellphone
        $cellphone = isset($value['cellphone']) ? $value['cellphone'] : $faker->phoneNumber();
        $member->setCellphone($cellphone);

        //userName
        $member->setUserName($cellphone);

        //realName
        $realName = isset($value['realName']) ? $value['realName'] : $faker->name();
        $member->setRealName($realName);

        //cardId
        $cardId = isset($value['cardId']) ? $value['cardId'] : $faker->creditCardNumber();
        $member->setCardId($cardId);

        //avatar
        $avatar = isset($value['avatar']) ? $value['avatar'] : array($faker->word());
        $member->setAvatar($avatar);

        //status
        $status = isset($value['status'])
        ? $value['status']
        : $faker->randomElement(IEnableAble::STATUS);
        $member->setStatus($status);

        $member->setCreateTime($faker->unixTime());
        $member->setUpdateTime($faker->unixTime());
        $member->setStatusTime($faker->unixTime());

        return $member;
    }
}
