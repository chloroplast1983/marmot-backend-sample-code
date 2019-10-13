<?php
namespace Homestay\Repository\Homestay;

use Homestay\Model\Homestay;
use Homestay\Adapter\Homestay\IHomestayAdapter;
use Homestay\Adapter\Homestay\HomestayDBAdapter;
use Homestay\Adapter\Homestay\HomestayMockAdapter;

use Marmot\Framework\Classes\Repository;

class HomestayRepository extends Repository implements IHomestayAdapter
{   
    private $adapter;
    
    public function __construct()
    {
        $this->adapter = new HomestayDBAdapter();
    }

    protected function getActualAdapter() : IHomestayAdapter
    {
        return $this->adapter;
    }

    protected function getMockAdapter() : IHomestayAdapter
    {
        return new HomestayMockAdapter();
    }

    public function fetchOne($id) : Homestay
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

    public function add(Homestay $homestay, array $keys = array()) : bool
    {
        return $this->getAdapter()->add($homestay, $keys);
    }

    public function edit(Homestay $homestay, array $keys = array()) : bool
    {
        return $this->getAdapter()->edit($homestay, $keys);
    }
}
