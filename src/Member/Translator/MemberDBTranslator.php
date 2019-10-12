<?php
namespace Member\Translator;

use Marmot\Interfaces\ITranslator;

use Member\Model\Member;
use Member\Model\NullMember;

class MemberDBTranslator implements ITranslator
{
     /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function arrayToObject(array $expression, $member = null)
    {
        if (!isset($expression['member_id'])) {
            return NullMember::getInstance();
        }

        if ($member == null) {
            $member = new Member();
        }

        $member->setId($expression['member_id']);

        if (isset($expression['cellphone'])) {
            $member->setCellphone($expression['cellphone']);
        }
        if (isset($expression['user_name'])) {
            $member->setUserName($expression['user_name']);
        }
        if (isset($expression['real_name'])) {
            $member->setRealName($expression['real_name']);
        }
        if (isset($expression['cardid'])) {
            $member->setCardId($expression['cardid']);
        }
        if (isset($expression['password'])) {
            $member->setPassword($expression['password']);
        }
        if (isset($expression['salt'])) {
            $member->setSalt($expression['salt']);
        }
        if (is_string($expression['avatar'])) {
            $member->setAvatar(json_decode($expression['avatar'], true));
        }
        $member->setCreateTime($expression['create_time']);
        $member->setUpdateTime($expression['update_time']);
        $member->setStatus($expression['status']);
        $member->setStatusTime($expression['status_time']);

        return $member;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($member, array $keys = array())
    {
        if (!$member instanceof Member) {
            return false;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'cellphone',
                'userName',
                'realName',
                'cardId',
                'avatar',
                'password',
                'salt',
                'updateTime',
                'createTime',
                'statusTime',
                'status'
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['member_id'] = $member->getId();
        }
        if (in_array('cellphone', $keys)) {
            $expression['cellphone'] = $member->getCellphone();
        }
        if (in_array('userName', $keys)) {
            $expression['user_name'] = $member->getUserName();
        }
        if (in_array('realName', $keys)) {
            $expression['real_name'] = $member->getRealName();
        }
        if (in_array('cardId', $keys)) {
            $expression['cardid'] = $member->getCardId();
        }
        if (in_array('avatar', $keys)) {
            $expression['avatar'] = $member->getAvatar();
        }
        if (in_array('password', $keys)) {
            $expression['password'] = $member->getPassword();
        }
        if (in_array('salt', $keys)) {
            $expression['salt'] = $member->getSalt();
        }
        if (in_array('createTime', $keys)) {
            $expression['create_time'] = $member->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['update_time'] = $member->getUpdateTime();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $member->getStatus();
        }
        if (in_array('statusTime', $keys)) {
            $expression['status_time'] = $member->getStatusTime();
        }

        return $expression;
    }
}
