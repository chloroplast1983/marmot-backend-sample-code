<?php
namespace UserGroup\Adapter\UserGroup;

use UserGroup\Translator\UserGroupDBTranslator;
use UserGroup\Adapter\UserGroup\Query\UserGroupRowCacheQuery;

class TestUserGroupDBAdapter extends UserGroupDBAdapter
{
    public function getDBTranslator() : UserGroupDBTranslator
    {
        return parent::getDBTranslator();
    }

    public function getRowCacheQuery() : UserGroupRowCacheQuery
    {
        return parent::getRowCacheQuery();
    }

    public function formatFilter(array $filter) : string
    {
        return parent::formatFilter($filter);
    }

    public function formatSort(array $sort) : string
    {
        return parent::formatSort($sort);
    }
}
