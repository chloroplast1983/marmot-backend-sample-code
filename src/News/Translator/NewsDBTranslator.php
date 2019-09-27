<?php
namespace News\Translator;

use Marmot\Interfaces\ITranslator;

use News\Model\News;
use News\Model\NullNews;

class NewsDBTranslator implements ITranslator
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function arrayToObject(array $expression, $news = null)
    {
        if (!isset($expression['news_id'])) {
            return NullNews::getInstance();
        }

        if ($news == null) {
            $news = new News($expression['news_id']);
        }
        
        if (isset($expression['title'])) {
            $news->setTitle($expression['title']);
        }
        if (isset($expression['source'])) {
            $news->setSource($expression['source']);
        }
        if (is_string($expression['image'])) {
            $news->setImage(json_decode($expression['image'], true));
        }
        if (is_string($expression['attachments'])) {
            $news->setAttachments(json_decode($expression['attachments'], true));
        }
        if (isset($expression['content'])) {
            $news->getContent()->setId($expression['content']);
        }
        if (isset($expression['publish_usergroup'])) {
            $news->getPublishUserGroup()->setId($expression['publish_usergroup']);
        }
        if (isset($expression['create_time'])) {
            $news->setCreateTime($expression['create_time']);
        }
        if (isset($expression['update_time'])) {
            $news->setUpdateTime($expression['update_time']);
        }
        if (isset($expression['status'])) {
            $news->setStatus($expression['status']);
        }
        if (isset($expression['status_time'])) {
            $news->setStatusTime($expression['status_time']);
        }

        return $news;
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function objectToArray($news, array $keys = array())
    {
        if (!$news instanceof News) {
            return false;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'title',
                'source',
                'image',
                'attachments',
                'content',
                'publishUserGroup',
                'createTime',
                'updateTime',
                'status',
                'statusTime'
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['news_id'] = $news->getId();
        }
        if (in_array('title', $keys)) {
            $expression['title'] = $news->getTitle();
        }
        if (in_array('source', $keys)) {
            $expression['source'] = $news->getSource();
        }
        if (in_array('image', $keys)) {
            $expression['image'] = $news->getImage();
        }
        if (in_array('attachments', $keys)) {
            $expression['attachments'] = $news->getAttachments();
        }
        if (in_array('content', $keys)) {
            $expression['content'] = $news->getContent()->getId();
        }
        if (in_array('publishUserGroup', $keys)) {
            $expression['publish_usergroup'] = $news->getPublishUserGroup()->getId();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $news->getStatus();
        }
        if (in_array('statusTime', $keys)) {
            $expression['status_time'] = $news->getStatusTime();
        }
        if (in_array('createTime', $keys)) {
            $expression['create_time'] = $news->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['update_time'] = $news->getUpdateTime();
        }

        return $expression;
    }
}
