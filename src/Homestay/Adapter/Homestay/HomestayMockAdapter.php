<?php
namespace Homestay\Adapter\Homestay;

use Homestay\Model\Homestay;
use Homestay\Utils\MockFactory;
use Homestay\Translator\HomestayDBTranslator;
use Homestay\Adapter\Homestay\Query\HomestayRowCacheQuery;

class HomestayMockAdapter implements IHomestayAdapter
{   
    public function add(Homestay $homestay, array $keys = array()) : bool
    {
        unset($homestay);

        return true;
    }

    public function edit(Homestay $homestay, array $keys = array()) : bool
    {
        unset($homestay);
        unset($keys);

        return true;
    }

    public function fetchOne($id) : Homestay
    {
        return MockFactory::generateHomestay($id);
    }

    public function fetchList(array $ids) : array
    {
        $homestayList = array();

        foreach ($ids as $id) {
            $homestayList[] = MockFactory::generateHomestay($id);
        }

        return $homestayList;
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
