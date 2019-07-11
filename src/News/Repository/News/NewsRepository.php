<?php
namespace News\Repository\News;

use News\Model\News;
use News\Adapter\News\INewsAdapter;
use News\Adapter\News\NewsDBAdapter;
use News\Adapter\News\NewsMockAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Common\Repository\OperatAbleRepositoryTrait;

class NewsRepository extends Repository implements INewsAdapter
{
    use OperatAbleRepositoryTrait;
    
    private $adapter;
    
    public function __construct()
    {
        $this->adapter = new NewsDBAdapter();
    }

    protected function getActualAdapter() : INewsAdapter
    {
        return $this->adapter;
    }

    protected function getMockAdapter() : INewsAdapter
    {
        return new NewsMockAdapter();
    }

    public function fetchOne($id) : News
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
