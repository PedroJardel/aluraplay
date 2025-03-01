<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginFormController implements ControllerInterface
{
    use HtmlRenderTrait;
    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        if (array_key_exists("logado", $_SESSION) && $_SESSION['logado'] === true) {
            return new Response (302, 
            [
                'Location' => '/'
            ]);
        }

        return new Response (200, body: $this->renderTemplate('login-form'));
    }
}