<?php
namespace Homestay\View;

use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @codeCoverageIgnore
 */
class HomestaySchema extends SchemaProvider
{
    protected $resourceType = 'homestaies';

    public function getId($homestay) : int
    {
        return $homestay->getId();
    }

    public function getAttributes($homestay) : array
    {
        return [
            'name'  => $homestay->getName(),
            'logo'  => $homestay->getLogo(),
            'status' => $homestay->getStatus(),
            'createTime' => $homestay->getCreateTime(),
            'updateTime' => $homestay->getUpdateTime(),
            'statusTime' => $homestay->getStatusTime()
        ];
    }
}
