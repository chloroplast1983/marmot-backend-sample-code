<?php
namespace Homestay\Adapter\Homestay\Query\Persistence;

use Marmot\Framework\Classes\Cache;

class HomestayCache extends Cache
{
    /**
     * 构造函数初始化key和表名一致
     */
    public function __construct()
    {
        parent::__construct('homestay');
    }
}
