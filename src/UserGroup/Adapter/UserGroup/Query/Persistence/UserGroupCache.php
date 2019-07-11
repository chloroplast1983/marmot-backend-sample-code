<?php
namespace UserGroup\Adapter\UserGroup\Query\Persistence;

use Marmot\Framework\Classes\Cache;

class UserGroupCache extends Cache
{
    /**
     * 构造函数初始化key和表名一致
     */
    public function __construct()
    {
        parent::__construct('usergroup');
    }
}
