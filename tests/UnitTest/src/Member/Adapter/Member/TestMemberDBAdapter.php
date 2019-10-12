<?php
namespace Member\Adapter\Member;

use Member\Translator\MemberDBTranslator;
use Member\Adapter\Member\Query\MemberRowCacheQuery;

class TestMemberDBAdapter extends MemberDBAdapter
{
    public function getDBTranslator() : MemberDBTranslator
    {
        return parent::getDBTranslator();
    }

    public function getRowCacheQuery() : MemberRowCacheQuery
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
