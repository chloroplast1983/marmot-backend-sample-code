<?php
namespace UserGroup\Utils;

use UserGroup\Model\UserGroup;

class ObjectGenerate
{
    public static function generateUserGroup(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : UserGroup {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $userGroup = new UserGroup($id);

        $userGroup->setId($id);

        //name
        $name = isset($value['name']) ? $value['name'] : $faker->name();
        $userGroup->setName($name);

        //status
        $status = isset($value['status']) ? $value['status'] : UserGroup::STATUS_NORMAL;
        $userGroup->setStatus($status);

        $userGroup->setCreateTime($faker->unixTime());
        $userGroup->setUpdateTime($faker->unixTime());
        $userGroup->setStatusTime($faker->unixTime());

        return $userGroup;
    }
}
