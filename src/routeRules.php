<?php
/**
 * \d+(,\d+)*
 * 路由设置
 */

$fetchControllerKeys = array_keys(\Common\Controller\Factory\FetchControllerFactory::MAPS);
$fetchControllerRoutes = '{resource:'.implode('|', $fetchControllerKeys).'}';

$operationControllerKeys = array_keys(\Common\Controller\Factory\OperationControllerFactory::MAPS);
$operationControllerRoutes = '{resource:'.implode('|', $operationControllerKeys).'}';

$enableControllerKeys = array_keys(\Common\Controller\Factory\EnableControllerFactory::MAPS);
$enableControllerRoutes = '{resource:'.implode('|', $enableControllerKeys).'}';

return [
        //监控检测
        [
            'method'=>'GET',
            'rule'=>'/healthz',
            'controller'=>[
                'Home\Controller\HealthzController',
                'healthz'
            ]
        ],
        [
            'method'=>['GET'],
            'rule'=>'/'.$fetchControllerRoutes,
            'controller'=>[
                'Common\Controller\FetchController',
                'filter'
            ]
        ],
        [
            'method'=>'GET',
            'rule'=>'/'.$fetchControllerRoutes.'/{id:\d+}',
            'controller'=>[
                'Common\Controller\FetchController',
                'fetchOne'
            ]
        ],
        [
            'method'=>'GET',
            'rule'=>'/'.$fetchControllerRoutes.'/{ids:\d+,[\d,]+}',
            'controller'=>[
                'Common\Controller\FetchController',
                'fetchList'
            ]
        ],
        [
            'method'=>'POST',
            'rule'=>'/'.$operationControllerRoutes,
            'controller'=>[
                'Common\Controller\OperationController',
                'add'
            ]
        ],
        [
            'method'=>'PATCH',
            'rule'=>'/'.$operationControllerRoutes.'/{id:\d+}',
            'controller'=>[
                'Common\Controller\OperationController',
                'edit'
            ]
        ],
        //启用
        [
            'method'=>'PATCH',
            'rule'=>'/'.$enableControllerRoutes.'/{id:\d+}/enable',
            'controller'=>[
                'Common\Controller\EnableController',
                'enable'
            ]
        ],
        //禁用
        [
            'method'=>'PATCH',
            'rule'=>'/'.$enableControllerRoutes.'/{id:\d+}/disable',
            'controller'=>[
                'Common\Controller\EnableController',
                'disable'
            ]
        ],
    ];
