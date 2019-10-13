<?php
namespace Homestay\Adapter\Homestay\Query\Persistence;

use Marmot\Framework\Classes\Db;

class HomestayDb extends Db
{
    public function __construct()
    {
        parent::__construct('homestay');
    }
}
