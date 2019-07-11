<?php
namespace UserGroup\View;

use UserGroup\Model\UserGroup;

use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @codeCoverageIgnore
 */
class UserGroupSchema extends SchemaProvider
{
    protected $resourceType = 'userGroups';

    public function getId($userGroup) : int
    {
        return $userGroup->getId();
    }

    public function getAttributes($userGroup) : array
    {
        return [
            'name'  => $userGroup->getName(),
            'status' => $userGroup->getStatus(),
            'createTime' => $userGroup->getCreateTime(),
            'updateTime' => $userGroup->getUpdateTime(),
            'statusTime' => $userGroup->getStatusTime()
        ];
    }
}
