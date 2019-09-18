<?php
namespace UserGroup\Adapter\UserGroup;

use UserGroup\Model\UserGroup;

interface IUserGroupAdapter
{
    public function fetchOne($id) : UserGroup;

    public function fetchList(array $ids) : array;

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 0
    ) : array;
}
