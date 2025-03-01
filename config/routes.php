<?php

use alura\mvc\Controller\DeleteVideoController;
use alura\mvc\Controller\EditVideoController;
use alura\mvc\Controller\JsonVideoListController;
use alura\mvc\Controller\LoginController;
use alura\mvc\Controller\LoginFormController;
use alura\mvc\Controller\LogoutController;
use alura\mvc\Controller\NewJsonVideoController;
use alura\mvc\Controller\NewVideoController;
use alura\mvc\Controller\RemoveThumbController;
use alura\mvc\Controller\VideoFormController;
use alura\mvc\Controller\VideoListController;

return [
     'GET|/' => VideoListController::class,
     'GET|/novo-video' => VideoFormController::class,
     'POST|/novo-video' => NewVideoController::class,
     'GET|/atualizar-video' => VideoFormController::class,
     'POST|/atualizar-video' => EditVideoController::class,
     'GET|/excluir-video' => DeleteVideoController::class,
     'GET|/login' => LoginFormController::class,
     'POST|/login' => LoginController::class,
     'GET|/logout' => LogoutController::class,
     'GET|/remover-capa' => RemoveThumbController::class,
     'GET|/videos-json' => JsonVideoListController::class,
     'POST|/videos' => NewJsonVideoController::class,
];