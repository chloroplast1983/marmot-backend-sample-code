<?php
namespace News\Model;

use Marmot\Core;
use Marmot\Framework\Interfaces\INull;

use Common\Model\NullEnableAbleTrait;
use Common\Model\NullOperatAbleTrait;

class NullNews extends News implements INull
{
    use NullEnableAbleTrait, NullOperatAbleTrait;

    private static $instance;
    
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function resourceNotExist() : bool
    {
        Core::setLastError(RESOURCE_NOT_EXIST);
        return false;
    }
}
