<?php
namespace UserGroup\Adapter\UserGroup\Query\Persistence;

use Marmot\Framework\Classes\Db;

class UserGroupDb extends Db
{
    public function __construct()
    {
        parent::__construct('usergroup');
    }
}
