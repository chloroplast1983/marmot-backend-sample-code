<?php
namespace Member\Repository\Member;

use Marmot\Framework\Classes\Repository;

use Member\Model\Member;
use Member\Adapter\Member\IMemberAdapter;
use Member\Adapter\Member\MemberDBAdapter;
use Member\Adapter\Member\MemberMockAdapter;

use Common\Repository\OperatAbleRepositoryTrait;

class MemberRepository extends Repository implements IMemberAdapter
{
    use OperatAbleRepositoryTrait;
    
    private $adapter;
    
    public function __construct()
    {
        $this->adapter = new MemberDBAdapter();
    }

    protected function getActualAdapter() : IMemberAdapter
    {
        return $this->adapter;
    }

    protected function getMockAdapter() : IMemberAdapter
    {
        return new MemberMockAdapter();
    }

    public function fetchOne($id) : Member
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
