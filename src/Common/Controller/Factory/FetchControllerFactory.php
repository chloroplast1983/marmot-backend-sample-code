<?php
namespace Common\Controller\Factory;

use Common\Controller\NullFetchController;
use Common\Controller\Interfaces\IFetchAbleController;

class FetchControllerFactory
{
    const MAPS = array(
        'news'=>'\News\Controller\FetchController'
    );

    public static function getFetchController(string $resource) : IFetchAbleController
    {
        $fetchController = isset(self::MAPS[$resource]) ? self::MAPS[$resource] : '';
        return class_exists($fetchController) ? new $fetchController : new NullFetchController();
    }
}
