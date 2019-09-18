<?php
namespace News\Adapter\News;

use News\Translator\NewsDBTranslator;
use News\Adapter\News\Query\NewsRowCacheQuery;

use UserGroup\Model\UserGroup;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class TestNewsDBAdapter extends NewsDBAdapter
{
    public function getDBTranslator() : NewsDBTranslator
    {
        return parent::getDBTranslator();
    }

    public function getRowCacheQuery() : NewsRowCacheQuery
    {
        return parent::getRowCacheQuery();
    }

    public function getContentDocumentAdapter() : ContentDocumentAdapter
    {
        return parent::getContentDocumentAdapter();
    }

    public function getUserGroupRepository() : UserGroupRepository
    {
        return parent::getUserGroupRepository();
    }

    public function fetchUserGroup(int $id) : UserGroup
    {
        return parent::fetchUserGroup($id);
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
