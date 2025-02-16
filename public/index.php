<?php

use alura\mvc\Infra\Database;

use alura\mvc\Controller\DeleteVideoController;
use alura\mvc\Controller\EditVideoController;
use alura\mvc\Controller\Error404Controller;
use alura\mvc\Controller\NewVideoController;
use alura\mvc\Controller\VideoFormController;
use alura\mvc\Controller\VideoListController;

use alura\mvc\Controller\Interfaces\ControllerInterface;

use alura\mvc\Repositories\VideoRepository;

require_once __DIR__ . "/../vendor/autoload.php";

$connection = Database::getConnection();
$videoRespository = new VideoRepository($connection);

if (!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER["PATH_INFO"] === '/') {
    $controller = new VideoListController($videoRespository);
} elseif ($_SERVER["PATH_INFO"] === '/novo-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new VideoFormController($videoRespository);

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new NewVideoController($videoRespository);

    }
} elseif ($_SERVER["PATH_INFO"] === '/atualizar-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new VideoFormController($videoRespository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new EditVideoController($videoRespository);
    }
} elseif ($_SERVER['PATH_INFO'] === '/excluir-video') {
    $controller = new DeleteVideoController($videoRespository);;
} else {
    $controller = new Error404Controller();;
}
/** @var ControllerInterface $controller */
$controller->requestProcess();