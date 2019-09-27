<?php
ini_set("display_errors","on");

return [
	//database
    'database.host'     => 'mysql',
    'database.port'     => 3306,
    'database.dbname'   => 'backend_sample',
    'database.user'		=> 'root',
    'database.password'	=> '123456',
    'database.tablepre' => 'pcore_',
    //mongo
    'mongo.host' => 'mongodb://mongo:27017',
    'mongo.uriOptions' => [
    ],
    'mongo.driverOptions' => [
    ],
    //cache
    'cache.route.disable' => true,
    //memcached
    'memcached.serevice'=>[['memcached-1',11211],['memcached-2',11211]],
];
