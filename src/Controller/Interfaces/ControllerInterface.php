<?php
namespace alura\mvc\Controller\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
{
    public function requestProcess(ServerRequestInterface $request): ResponseInterface;
}