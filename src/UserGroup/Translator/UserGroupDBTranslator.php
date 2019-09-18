<?php
namespace UserGroup\Translator;

use Marmot\Framework\Interfaces\ITranslator;

use UserGroup\Model\UserGroup;
use UserGroup\Model\NullUserGroup;

class UserGroupDBTranslator implements ITranslator
{
    public function arrayToObject(array $expression, $userGroup = null)
    {
        if (!isset($expression['usergroup_id'])) {
            return NullUserGroup::getInstance();
        }

        if ($userGroup == null) {
            $userGroup = new UserGroup();
        }

        $userGroup->setId($expression['usergroup_id']);

        if (isset($expression['name'])) {
            $userGroup->setName($expression['name']);
        }
        $userGroup->setCreateTime($expression['create_time']);
        $userGroup->setUpdateTime($expression['update_time']);
        $userGroup->setStatus($expression['status']);
        $userGroup->setStatusTime($expression['status_time']);

        return $userGroup;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function objectToArray($userGroup, array $keys = array())
    {
        if (!$userGroup instanceof UserGroup) {
            return false;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'updateTime',
                'createTime',
                'statusTime',
                'status'
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['usergroup_id'] = $userGroup->getId();
        }
        if (in_array('name', $keys)) {
            $expression['name'] = $userGroup->getName();
        }
        if (in_array('createTime', $keys)) {
            $expression['create_time'] = $userGroup->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['update_time'] = $userGroup->getUpdateTime();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $userGroup->getStatus();
        }
        if (in_array('statusTime', $keys)) {
            $expression['status_time'] = $userGroup->getStatusTime();
        }

        return $expression;
    }
}
