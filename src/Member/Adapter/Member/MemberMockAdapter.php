<?php
namespace Member\Adapter\Member;

use Member\Model\Member;
use Member\Utils\MockFactory;
use Member\Translator\MemberDBTranslator;
use Member\Adapter\Member\Query\MemberRowCacheQuery;

use Common\Model\IOperatAble;
use Common\Adapter\OperatAbleRestfulAdapterTrait;

class MemberMockAdapter implements IMemberAdapter
{
    use OperatAbleRestfulAdapterTrait;
    
    private $translator;

    private $rowCacheQuery;

    public function __construct()
    {
        $this->translator = new MemberDBTranslator();
        $this->rowCacheQuery = new MemberRowCacheQuery();
    }

    public function __destruct()
    {
        unset($this->translator);
        unset($this->rowCacheQuery);
    }
    
    protected function getDBTranslator() : MemberDBTranslator
    {
        return $this->translator;
    }
    
    protected function getRowCacheQuery() : MemberRowCacheQuery
    {
        return $this->rowCacheQuery;
    }
    
    public function add(IOperatAble $member, array $keys = array()) : bool
    {
        unset($member);

        return true;
    }

    public function edit(IOperatAble $member, array $keys = array()) : bool
    {
        unset($member);
        unset($keys);

        return true;
    }

    public function fetchOne($id) : Member
    {
        return MockFactory::generateMember($id);
    }

    public function fetchList(array $ids) : array
    {
        $memberList = array();

        foreach ($ids as $id) {
            $memberList[] = MockFactory::generateMember($id);
        }

        return $memberList;
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
