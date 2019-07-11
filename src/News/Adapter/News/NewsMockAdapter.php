<?php
namespace News\Adapter\News;

use News\Model\News;
use News\Utils\ObjectGenerate;
use News\Translator\NewsDBTranslator;
use News\Adapter\News\Query\NewsRowCacheQuery;

use Common\Model\IOperatAble;
use Common\Adapter\OperatAbleRestfulAdapterTrait;

class NewsMockAdapter implements INewsAdapter
{
    use OperatAbleRestfulAdapterTrait;
    
    private $translator;

    private $rowCacheQuery;

    public function __construct()
    {
        $this->translator = new NewsDBTranslator();
        $this->rowCacheQuery = new NewsRowCacheQuery();
    }

    public function __destruct()
    {
        unset($this->translator);
        unset($this->rowCacheQuery);
    }
    
    protected function getDBTranslator() : NewsDBTranslator
    {
        return $this->translator;
    }
    
    protected function getRowCacheQuery() : NewsRowCacheQuery
    {
        return $this->rowCacheQuery;
    }
    
    public function add(IOperatAble $news, array $keys = array()) : bool
    {
        unset($news);

        return true;
    }

    public function edit(IOperatAble $news, array $keys = array()) : bool
    {
        unset($news);
        unset($keys);

        return true;
    }

    public function fetchOne($id) : News
    {
        return ObjectGenerate::generateNews($id);
    }

    public function fetchList(array $ids) : array
    {
        $newsList = array();

        foreach ($ids as $id) {
            $newsList[] = ObjectGenerate::generateNews($id);
        }

        return $newsList;
    }

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {

        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);

        return array($this->fetchList($ids), $count);
    }
}
