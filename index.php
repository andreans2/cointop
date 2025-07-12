<?php

define('APP_PATH', __DIR__);

require_once APP_PATH . '/src/Database.php';
require_once APP_PATH . '/src/Fetcher.php';
require_once APP_PATH . '/src/CryptoRepository.php';

$routes = require_once APP_PATH . "/config/routes.php";

$uri = $_SERVER['REQUEST_URI'];

if (isset($routes[$uri])) {
    $routes[$uri]();
} else {
    http_response_code(404);
    include_once APP_PATH."/templates/pages/404.php";
}