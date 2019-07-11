<?php
namespace News\Adapter\News;

use Marmot\Core;

use Common\Adapter\OperatAbleRestfulAdapterTrait;
use Common\Adapter\FetchRestfulAdapterTrait;

use News\Model\News;
use News\Model\NullNews;
use News\Translator\NewsDBTranslator;
use News\Adapter\News\Query\NewsRowCacheQuery;

use UserGroup\Model\UserGroup;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class NewsDBAdapter implements INewsAdapter
{
    use OperatAbleRestfulAdapterTrait, FetchRestfulAdapterTrait;

    private $translator;

    private $rowCacheQuery;

    private $contentDocumentAdapter;

    private $userGroupRepository;

    public function __construct()
    {
        $this->translator = new NewsDBTranslator();
        $this->rowCacheQuery = new NewsRowCacheQuery();
        $this->contentDocumentAdapter = new ContentDocumentAdapter();
        $this->userGroupRepository = new UserGroupRepository();
    }

    public function __destruct()
    {
        unset($this->translator);
        unset($this->rowCacheQuery);
        unset($this->contentDocumentAdapter);
        unset($this->userGroupRepository);
    }
    
    protected function getDBTranslator() : NewsDBTranslator
    {
        return $this->translator;
    }
    
    protected function getRowCacheQuery() : NewsRowCacheQuery
    {
        return $this->rowCacheQuery;
    }
    
    protected function getContentDocumentAdapter() : ContentDocumentAdapter
    {
        return $this->contentDocumentAdapter;
    }
    
    protected function getUserGroupRepository() : UserGroupRepository
    {
        return $this->userGroupRepository;
    }

    protected function fetchUserGroup(int $id) : UserGroup
    {
        return $this->getUserGroupRepository()->fetchOne($id);
    }

    public function fetchOne($id) : News
    {
        $info = array();

        $info = $this->getRowCacheQuery()->getOne($id);

        if (empty($info)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return NullNews::getInstance();
        }

        $news = $this->getDBTranslator()->arrayToObject($info);

        if ($news instanceof News) {
            $this->getContentDocumentAdapter()->fetchOne($news->getContent());
        }

        $userGroup = $this->fetchUserGroup($news->getPublishUserGroup()->getId());
        if (!empty($userGroup)) {
            $news->setPublishUserGroup($userGroup);
        }

        return $news;
    }

    public function fetchList(array $ids) : array
    {
        $newsList = array();
        $contentDocuments = array();
        
        $newsInfoList = $this->getRowCacheQuery()->getList($ids);

        if (empty($newsInfoList)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array();
        }

        $translator = $this->getDBTranslator();
        foreach ($newsInfoList as $newsInfo) {
            $news = $translator->arrayToObject($newsInfo);

            if (!empty($news->getContent()->getId())) {
                $contentDocuments[] = $news->getContent();
            }

            $userGroupIds[$news->getId()] = $news->getPublishUserGroup()->getId();

            $newsList[] = $news;
        }

        if (!empty($contentDocuments)) {
            $this->getContentDocumentAdapter()->fetchList($contentDocuments);
        }

        $userGroupList = $this->getUserGroupRepository()->fetchList($userGroupIds);
        if (!empty($userGroupList)) {
            foreach ($newsList as $key => $news) {
                if (isset($userGroupList[$key])) {
                    $news->setPublishUserGroup($userGroupList[$key]);
                }
            }
        }
        
        return $newsList;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function formatFilter(array $filter) : string
    {
        $condition = $conjection = '';

        if (!empty($filter)) {
            $news = new News();

            if (isset($filter['title']) && !empty($filter['title'])) {
                $news->setTitle($filter['title']);
                $info = $this->getDBTranslator()->objectToArray($news, array('title'));
                $condition .= $conjection.key($info).' LIKE \'%'.current($info).'%\'';
                $conjection = ' AND ';
            }
            if (isset($filter['status'])) {
                $status = $filter['status'];
                if (is_numeric($status)) {
                    $news->setStatus($filter['status']);
                    $info = $this->getDBTranslator()->objectToArray(
                        $news,
                        array('status')
                    );
                    $condition .= $conjection.key($info).' = '.current($info);
                }
                if (strpos($status, ',')) {
                    $info = $this->getDBTranslator()->objectToArray(
                        $news,
                        array('status')
                    );
                    $condition .= $conjection.key($info).' IN ('.$status.')';
                }
                $conjection = ' AND ';
            }
            if (isset($filter['publishUserGroup']) && !empty($filter['publishUserGroup'])) {
                $news->getPublishUserGroup()->setId($filter['publishUserGroup']);
                $info = $this->getDBTranslator()->objectToArray(
                    $news,
                    array('publishUserGroup')
                );
                $condition .= $conjection.key($info).' = '.current($info);
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
            $news = new News();
            if (isset($sort['updateTime'])) {
                $info = $this->getDBTranslator()->objectToArray($news, array('updateTime'));
                $condition .= $conjection.key($info).' '.($sort['updateTime'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
            if (isset($sort['status'])) {
                $info = $this->getDBTranslator()->objectToArray($news, array('status'));
                $condition .= $conjection.key($info).' '.($sort['status'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
            if (isset($sort['id'])) {
                $info = $this->getDBTranslator()->objectToArray($news, array('id'));
                $condition .= $conjection.key($info).' '.($sort['id'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
        }

        return $condition;
    }
}
