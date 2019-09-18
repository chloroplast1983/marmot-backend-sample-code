<?php
namespace UserGroup\Adapter\UserGroup\Query;

use Marmot\Framework\Query\RowCacheQuery;

class UserGroupRowCacheQuery extends RowCacheQuery
{
    public function __construct()
    {
        parent::__construct(
            'usergroup_id',
            new Persistence\UserGroupCache(),
            new Persistence\UserGroupDb()
        );
    }
}
