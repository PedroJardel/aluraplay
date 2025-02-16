<?php

use alura\mvc\Infra\Database;
use alura\mvc\Controller\Error404Controller;
use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Repositories\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = Database::getConnection();
$videoRespository = new VideoRepository($connection);

$routes = require_once __DIR__ .'/../config/routes.php';

$pathInfo = $_SERVER["PATH_INFO"] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";
if(array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];
    $controller = new $controllerClass($videoRespository);
} else {
    $controller = new Error404Controller();
}
/** @var ControllerInterface $controller */
$controller->requestProcess();