<?php
namespace UserGroup\Adapter\UserGroup;

use UserGroup\Model\UserGroup;
use UserGroup\Utils\ObjectGenerate;
use UserGroup\Translator\UserGroupDBTranslator;
use UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery;

class UserGroupMockAdapter implements IUserGroupAdapter
{
    public function fetchOne($id) : UserGroup
    {
        return ObjectGenerate::generateUserGroup($id);
    }

    public function fetchList(array $ids) : array
    {
        $userGroupList = array();

        foreach ($ids as $id) {
            $userGroupList[] = ObjectGenerate::generateUserGroup($id);
        }

        return $userGroupList;
    }

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {

        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);

        return array($this->fetchList($ids), $count);
    }
}
