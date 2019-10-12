<?php
namespace Member\Adapter\Member\Query\Persistence;

use Marmot\Framework\Classes\Db;

class MemberDb extends Db
{
    public function __construct()
    {
        parent::__construct('member');
    }
}
