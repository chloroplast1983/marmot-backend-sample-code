<?php
namespace UserGroup\Adapter\UserGroup;

use Marmot\Core;

use Common\Adapter\FetchRestfulAdapterTrait;

use UserGroup\Model\UserGroup;
use UserGroup\Model\NullUserGroup;
use UserGroup\Translator\UserGroupDBTranslator;
use UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery;

class UserGroupDBAdapter implements IUserGroupAdapter
{
    use FetchRestfulAdapterTrait;

    private $translator;

    private $rowCacheQuery;

    public function __construct()
    {
        $this->translator = new UserGroupDBTranslator();
        $this->rowCacheQuery = new UserGroupRowCacheQuery();
    }

    public function __destruct()
    {
        unset($this->translator);
        unset($this->rowCacheQuery);
    }
    
    protected function getDBTranslator() : UserGroupDBTranslator
    {
        return $this->translator;
    }
    
    protected function getRowCacheQuery() : UserGroupRowCacheQuery
    {
        return $this->rowCacheQuery;
    }

    public function fetchOne($id) : UserGroup
    {
        $info = array();

        $info = $this->getRowCacheQuery()->getOne($id);

        if (empty($info)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return NullUserGroup::getInstance();
        }

        return $this->getDBTranslator()->arrayToObject($info);
    }

    public function fetchList(array $ids) : array
    {
        $userGroupList = array();
        
        $userGroupInfoList = $this->getRowCacheQuery()->getList($ids);

        if (empty($userGroupInfoList)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array();
        }

        $translator = $this->getDBTranslator();
        foreach ($userGroupInfoList as $userGroupInfo) {
            $userGroup = $translator->arrayToObject($userGroupInfo);

            $userGroupList[] = $userGroup;
        }
        
        return $userGroupList;
    }

    protected function formatFilter(array $filter) : string
    {
        $condition = $conjection = '';

        if (!empty($filter)) {
            $userGroup = new UserGroup();

            if (isset($filter['name']) && !empty($filter['name'])) {
                $userGroup->setName($filter['name']);
                $info = $this->getDBTranslator()->objectToArray($userGroup, array('name'));
                $condition .= $conjection.key($info).' LIKE \'%'.current($info).'%\'';
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
            $userGroup = new UserGroup();
            if (isset($sort['id'])) {
                $info = $this->getDBTranslator()->objectToArray($userGroup, array('id'));
                $condition .= $conjection.key($info).' '.($sort['id'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
        }

        return $condition;
    }
}
