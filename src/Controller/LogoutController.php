<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;


class LogoutController implements ControllerInterface
{
    public function requestProcess()
    {
        unset($_SESSION["logado"]);
        header("Location: /login");
    }
}