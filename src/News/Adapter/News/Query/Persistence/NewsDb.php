<?php
namespace News\Adapter\News\Query\Persistence;

use Marmot\Framework\Classes\Db;

class NewsDb extends Db
{
    public function __construct()
    {
        parent::__construct('news');
    }
}
