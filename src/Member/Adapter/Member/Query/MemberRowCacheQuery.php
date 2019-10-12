<?php
namespace Member\Adapter\Member\Query;

use Marmot\Framework\Query\RowCacheQuery;

class MemberRowCacheQuery extends RowCacheQuery
{
    public function __construct()
    {
        parent::__construct(
            'member_id',
            new Persistence\MemberCache(),
            new Persistence\MemberDb()
        );
    }
}
