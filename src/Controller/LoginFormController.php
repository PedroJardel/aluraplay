<?php
namespace alura\mvc\Controller;

use alura\mvc\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginFormController implements RequestHandlerInterface
{
    use HtmlRenderTrait;
    public function handle(ServerRequestInterface $request): ResponseInterface
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