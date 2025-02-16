<?php

use alura\mvc\Controller\DeleteVideoController;
use alura\mvc\Controller\EditVideoController;
use alura\mvc\Controller\LoginController;
use alura\mvc\Controller\LoginFormController;
use alura\mvc\Controller\NewVideoController;
use alura\mvc\Controller\VideoFormController;
use alura\mvc\Controller\VideoListController;

return [
     'GET|/' => VideoListController::class,
     'GET|/novo-video' => VideoFormController::class,
     'POST|/novo-video' => NewVideoController::class,
     'POST|/atualizar-video' => EditVideoController::class,
     'GET|/atualizar-video' => EditVideoController::class,
     'GET|/excluir-video' => DeleteVideoController::class,
     'GET|/login' => LoginFormController::class,
     'POST|/login' => LoginController::class,
];