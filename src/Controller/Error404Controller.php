<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Error404Controller implements ControllerInterface
{
    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
       return new Response(404);
    }
}