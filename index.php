<?php

session_start();

use core\Container;
use core\Database\Connection;
use core\Database\QueryBuilder;
use core\Request;
use core\Router;

require __DIR__ . '/autoload.php';
require __DIR__ . '/vendor/autoload.php';

Container::bind('config', __DIR__ . '/core/config.php');
Container::bind('routes', __DIR__ . '/core/routes.php');
Container::bind('database', QueryBuilder::instance(
    Connection::make(Container::get('config'))
)
);

$uri = Request::getUri();
$requestMethod = Request::getRequestMethod();

Router::load(Container::get('routes'))
    ->direct($uri, $requestMethod);
