<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;

class Error404Controller implements ControllerInterface
{
    public function requestProcess()
    {
        http_response_code(404);
    }
}