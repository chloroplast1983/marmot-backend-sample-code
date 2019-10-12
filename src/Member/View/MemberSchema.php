<?php
namespace Member\View;

use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * @codeCoverageIgnore
 */
class MemberSchema extends SchemaProvider
{
    protected $resourceType = 'members';

    public function getId($member) : int
    {
        return $member->getId();
    }

    public function getAttributes($member) : array
    {
        return [
            'cellphone'  => $member->getCellphone(),
            'userName' => $member->getUserName(),
            'realName' => $member->getRealName(),
            'cardId'  => $member->getCardId(),
            'avatar'  => $member->getAvatar(),
            'status' => $member->getStatus(),
            'createTime' => $member->getCreateTime(),
            'updateTime' => $member->getUpdateTime(),
            'statusTime' => $member->getStatusTime()
        ];
    }
}
