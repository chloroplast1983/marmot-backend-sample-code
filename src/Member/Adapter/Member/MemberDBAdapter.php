<?php
namespace Member\Adapter\Member;

use Marmot\Core;

use Common\Adapter\FetchRestfulAdapterTrait;
use Common\Adapter\OperatAbleRestfulAdapterTrait;

use Member\Model\Member;
use Member\Model\NullMember;
use Member\Translator\MemberDBTranslator;
use Member\Adapter\Member\Query\MemberRowCacheQuery;

class MemberDBAdapter implements IMemberAdapter
{
    use OperatAbleRestfulAdapterTrait, FetchRestfulAdapterTrait;

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

    public function fetchOne($id) : Member
    {
        $info = array();

        $info = $this->getRowCacheQuery()->getOne($id);

        if (empty($info)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return NullMember::getInstance();
        }

        return $this->getDBTranslator()->arrayToObject($info);
    }

    public function fetchList(array $ids) : array
    {
        $memberList = array();
        
        $memberInfoList = $this->getRowCacheQuery()->getList($ids);

        if (empty($memberInfoList)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array();
        }

        $translator = $this->getDBTranslator();
        foreach ($memberInfoList as $memberInfo) {
            $member = $translator->arrayToObject($memberInfo);

            $memberList[] = $member;
        }
        
        return $memberList;
    }

    protected function formatFilter(array $filter) : string
    {
        $condition = $conjection = '';

        if (!empty($filter)) {
            $member = new Member();

            if (isset($filter['realName']) && !empty($filter['realName'])) {
                $member->setRealName($filter['realName']);
                $info = $this->getDBTranslator()->objectToArray($member, array('realName'));
                $condition .= $conjection.key($info).' LIKE \'%'.current($info).'%\'';
                $conjection = ' AND ';
            }
            if (isset($filter['cellphone'])) {
                $member->setCellphone($filter['cellphone']);
                $info = $this->getDBTranslator()->objectToArray($member, array('cellphone'));
                $condition .= $conjection.key($info).' = \''.current($info).'\'';
                $conjection = ' AND ';
            }
        }

        return empty($condition) ? ' 1 ' : $condition ;
    }

    protected function formatSort(array $sort) : string
    {
        $condition = '';
        $conjection = ' ORDER BY ';

        if (!empty($sort)) {
            $member = new Member();
            if (isset($sort['updateTime'])) {
                $info = $this->getDBTranslator()->objectToArray($member, array('updateTime'));
                $condition .= $conjection.key($info).' '.($sort['updateTime'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
            if (isset($sort['id'])) {
                $info = $this->getDBTranslator()->objectToArray($member, array('id'));
                $condition .= $conjection.key($info).' '.($sort['id'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
        }

        return $condition;
    }
}
