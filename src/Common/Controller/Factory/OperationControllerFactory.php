<?php
namespace Common\Controller\Factory;

use Common\Controller\NullOperationController;
use Common\Controller\Interfaces\IOperatAbleController;

class OperationControllerFactory
{
    const MAPS = array(
        'news'=>'\News\Controller\OperationController',
        'members'=>'\Member\Controller\OperationController'
    );

    public static function getController(string $resource) : IOperatAbleController
    {
        $operateController = isset(self::MAPS[$resource]) ? self::MAPS[$resource] : '';
        return class_exists($operateController) ? new $operateController : new NullOperationController();
    }
}
