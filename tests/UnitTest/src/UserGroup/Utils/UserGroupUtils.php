<?php
namespace UserGroup\Utils;

trait UserGroupUtils
{
    private function compareArrayAndObject(
        array $expectedArray,
        $userGroup
    ) {
        $this->assertEquals($expectedArray['usergroup_id'], $userGroup->getId());
        $this->assertEquals($expectedArray['name'], $userGroup->getName());
        $this->assertEquals($expectedArray['status'], $userGroup->getStatus());
        $this->assertEquals($expectedArray['create_time'], $userGroup->getCreateTime());
        $this->assertEquals($expectedArray['update_time'], $userGroup->getUpdateTime());
        $this->assertEquals($expectedArray['status_time'], $userGroup->getStatusTime());
    }
}
