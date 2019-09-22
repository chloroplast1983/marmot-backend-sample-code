<?php
namespace News\Adapter\News;

use Marmot\Core;

use Common\Adapter\FetchRestfulAdapterTrait;
use Common\Adapter\OperatAbleRestfulAdapterTrait;

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

    public function fetchOne($id) : News
    {
        $info = array();

        $info = $this->getRowCacheQuery()->getOne($id);

        if (empty($info)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return NullNews::getInstance();
        }

        $news = $this->getDBTranslator()->arrayToObject($info);

        if (!empty($news->getContent()->getId())) {
            $this->getContentDocumentAdapter()->fetchOne($news->getContent());
        }

        $this->fetchPublishUserGroup($news);

        return $news;
    }

    public function fetchList(array $ids) : array
    {
        $newsList = array();
        
        $newsInfoList = $this->getRowCacheQuery()->getList($ids);

        if (empty($newsInfoList)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array();
        }

        $translator = $this->getDBTranslator();

        foreach ($newsInfoList as $newsInfo) {
            $newsList[] = $translator->arrayToObject($newsInfo);
        }

        $this->fetchPublishUserGroup($newsList);
        
        return $newsList;
    }

    protected function fetchPublishUserGroup($news)
    {
        return is_array($news) ?
        $this->fetchPublishUserGroupByList($news) :
        $this->fetchPublishUserGroupByObject($news);
    }

    private function fetchPublishUserGroupByObject(News $news)
    {
        $userGroupId = $news->getPublishUserGroup()->getId();
        $userGroup = $this->getUserGroupRepository()->fetchOne($userGroupId);
        $news->setPublishUserGroup($userGroup);
    }

    private function fetchPublishUserGroupByList(array $newsList)
    {
        $userGroupIds = array();
        foreach ($newsList as $news) {
            $userGroupIds[] = $news->getPublishUserGroup()->getId();
        }

        $userGroupList = $this->getUserGroupRepository()->fetchList($userGroupIds);
        if (!empty($userGroupList)) {
            foreach ($newsList as $key => $news) {
                if (isset($userGroupList[$key])
                    && $userGroupList[$key]->getId() == $news->getPublishUserGroup()->getId()) {
                       $news->setPublishUserGroup($userGroupList[$key]);
                }
            }
        }
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
