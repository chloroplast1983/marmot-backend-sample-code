<?php
namespace News\Adapter\News\Query\Persistence;

use Marmot\Framework\Classes\Cache;

class NewsCache extends Cache
{
    /**
     * 构造函数初始化key和表名一致
     */
    public function __construct()
    {
        parent::__construct('news');
    }
}
