<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutController implements ControllerInterface
{
    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        unset($_SESSION["logado"]);
        return new Response( 302,
        [
            'Location' => '/login'
        ]);
    }
}