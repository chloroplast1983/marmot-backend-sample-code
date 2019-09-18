<?php
namespace News\View;

use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @codeCoverageIgnore
 */
class NewsSchema extends SchemaProvider
{
    protected $resourceType = 'news';

    public function getId($news) : int
    {
        return $news->getId();
    }

    public function getAttributes($news) : array
    {
        $content = $news->getContent()->getData();
        $contentSchema = !empty($content) ? $content['content'] : '';

        return [
            'title'  => $news->getTitle(),
            'source'  => $news->getSource(),
            'image'  => $news->getImage(),
            'attachments'  => $news->getAttachments(),
            'content'  => $contentSchema,
            'status' => $news->getStatus(),
            'createTime' => $news->getCreateTime(),
            'updateTime' => $news->getUpdateTime(),
            'statusTime' => $news->getStatusTime()
        ];
    }

    public function getRelationships($news, $isPrimary, array $includeList)
    {
        unset($isPrimary);
        unset($includeList);
        
        return [
            'publishUserGroup' => [self::DATA => $news->getPublishUserGroup()]
        ];
    }
}
