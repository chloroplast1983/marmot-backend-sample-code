<?php
namespace UserGroup\Model;

use Marmot\Framework\Interfaces\INull;

class NullUserGroup extends UserGroup implements INull
{
    private static $instance;
    
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
