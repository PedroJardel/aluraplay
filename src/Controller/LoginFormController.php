<?php
namespace alura\mvc\Controller;

use alura\mvc\Helper\HtmlRenderTrait;

class LoginFormController
{
    use HtmlRenderTrait;
    public function requestProcess()
    {
        if (array_key_exists("logado", $_SESSION) && $_SESSION['logado'] === true) {
            header('Location: /');
        }
        if (isset($_SESSION['message'])) {
            echo "<script>
            alert('{$_SESSION['message']}');
             window.location.href = '/login';
            </script>";
            unset($_SESSION['message']);
        }

        echo $this->renderTemplate('login-form');
    }
}