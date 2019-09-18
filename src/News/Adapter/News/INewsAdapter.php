<?php
namespace News\Adapter\News;

use News\Model\News;

use Common\Adapter\IOperatAbleAdapter;

interface INewsAdapter extends IOperatAbleAdapter
{
    public function fetchOne($id) : News;

    public function fetchList(array $ids) : array;

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 0
    ) : array;
}
