<?php
namespace Homestay\Adapter\Homestay;

use Homestay\Model\Homestay;

interface IHomestayAdapter
{
    public function fetchOne($id) : Homestay;

    public function fetchList(array $ids) : array;

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 0
    ) : array;

    public function add(Homestay $homestay, array $keys = array()) : bool;

    public function edit(Homestay $homestay, array $keys = array()) : bool;
}
