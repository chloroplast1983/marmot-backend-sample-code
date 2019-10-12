<?php
namespace Member\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

class NullMember extends Member implements INull
{
    private static $instance;
    
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function resourceNotExist() : bool
    {
        Core::setLastError(RESOURCE_NOT_EXIST);
        return false;
    }

    public function signUp() : bool
    {
        return $this->resourceNotExist();
    }
}
