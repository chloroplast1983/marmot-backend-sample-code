<?php
namespace Member\Adapter\Member;

use Member\Model\Member;

use Common\Adapter\IOperatAbleAdapter;

interface IMemberAdapter extends IOperatAbleAdapter
{
    public function fetchOne($id) : Member;

    public function fetchList(array $ids) : array;

    public function filter(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 0
    ) : array;
}
