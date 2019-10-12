<?php
namespace Member\Utils;

trait MemberUtils
{
    private function compareArrayAndObject(
        array $expectedArray,
        $member
    ) {
        $this->assertEquals($expectedArray['member_id'], $member->getId());
        $this->assertEquals($expectedArray['cellphone'], $member->getCellphone());
        $this->assertEquals($expectedArray['user_name'], $member->getUserName());
        $this->assertEquals($expectedArray['real_name'], $member->getRealName());
        $this->assertEquals($expectedArray['cardid'], $member->getCardId());
        $this->assertEquals($expectedArray['password'], $member->getPassword());
        $this->assertEquals($expectedArray['salt'], $member->getSalt());
        $avatar = array();

        if (is_string($expectedArray['avatar'])) {
            $avatar = json_decode($expectedArray['avatar'], true);
        }
        if (is_array($expectedArray['avatar'])) {
            $avatar = $expectedArray['avatar'];
        }

        $this->assertEquals($avatar, $member->getAvatar());
        $this->assertEquals($expectedArray['status'], $member->getStatus());
        $this->assertEquals($expectedArray['create_time'], $member->getCreateTime());
        $this->assertEquals($expectedArray['update_time'], $member->getUpdateTime());
        $this->assertEquals($expectedArray['status_time'], $member->getStatusTime());
    }
}
