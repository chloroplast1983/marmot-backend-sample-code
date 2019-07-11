<?php
namespace UserGroup\Repository\UserGroup;

use Marmot\Framework\Classes\Repository;

use UserGroup\Model\UserGroup;
use UserGroup\Adapter\UserGroup\IUserGroupAdapter;
use UserGroup\Adapter\UserGroup\UserGroupDBAdapter;
use UserGroup\Adapter\UserGroup\UserGroupMockAdapter;

class UserGroupRepository extends Repository implements IUserGroupAdapter
{
    private $adapter;
    
    public function __construct()
    {
        $this->adapter = new UserGroupDBAdapter();
    }

    protected function getActualAdapter() : IUserGroupAdapter
    {
        return $this->adapter;
    }

    protected function getMockAdapter() : IUserGroupAdapter
    {
        return new UserGroupMockAdapter();
    }

    public function fetchOne($id) : UserGroup
    {
        return $this->getAdapter()->fetchOne($id);
    }

    public function fetchList(array $ids) : array
    {
        return $this->getAdapter()->fetchList($ids);
    }

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) : array {
        return $this->getAdapter()->filter($filter, $sort, $offset, $size);
    }
}
