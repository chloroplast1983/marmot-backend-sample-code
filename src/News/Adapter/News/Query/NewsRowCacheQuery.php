<?php
namespace News\Adapter\News\Query;

use Marmot\Framework\Query\RowCacheQuery;

class NewsRowCacheQuery extends RowCacheQuery
{
    public function __construct()
    {
        parent::__construct(
            'news_id',
            new Persistence\NewsCache(),
            new Persistence\NewsDb()
        );
    }
}
