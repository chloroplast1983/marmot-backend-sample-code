<?php
namespace Homestay\Adapter\Homestay\Query;

use Marmot\Framework\Query\RowCacheQuery;

class HomestayRowCacheQuery extends RowCacheQuery
{
    public function __construct()
    {
        parent::__construct(
            'homestay_id',
            new Persistence\HomestayCache(),
            new Persistence\HomestayDb()
        );
    }
}
