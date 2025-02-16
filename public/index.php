<?php

require_once __DIR__ ."/../vendor/autoload.php";

if(!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER["PATH_INFO"] === '/') {
    require_once  __DIR__ . '/../listagem-videos.php';
} elseif ($_SERVER["PATH_INFO"] === '/novo-video') {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once  __DIR__ . '/../enviar-video.php';
    } elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once  __DIR__ . '/../novo-video.php';
    }

} elseif ($_SERVER["PATH_INFO"] === '/atualizar-video') {
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once  __DIR__ . '/../enviar-video.php';
    } elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once  __DIR__ . '/../atualizar-video.php';
    }
} elseif ($_SERVER['PATH_INFO'] === '/excluir-video') {
    require_once  __DIR__ . '/../excluir-video.php';
} else {
    http_response_code(   404);
}