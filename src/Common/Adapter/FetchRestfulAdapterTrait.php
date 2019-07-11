<?php
namespace Common\Adapter;

use Marmot\Core;

trait FetchRestfulAdapterTrait
{
    abstract protected function formatFilter() : string;

    abstract protected function formatSort() : string;
    
    abstract protected function getRowCacheQuery();

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) : array {
        $condition = $this->formatFilter($filter);
        $condition .= $this->formatSort($sort);

        $rowCacheQuery = $this->getRowCacheQuery();
        $list = $rowCacheQuery->find($condition, $offset, $size);

        if (empty($list)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array(array(), 0);
        }

        $ids = array();
        $primaryKey = $rowCacheQuery->getPrimaryKey();
        foreach ($list as $info) {
            $ids[] = $info[$primaryKey];
        }

        $count = 0;

        $count = sizeof($ids);
        if ($count  == $size || $offset > 0) {
            $count = $rowCacheQuery->count($condition);
        }

        return array($this->fetchList($ids), $count);
    }
}
