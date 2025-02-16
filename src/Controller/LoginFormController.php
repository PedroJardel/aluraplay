<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;

class LoginFormController implements ControllerInterface
{
    public function requestProcess()
    {
        session_start();
        if (isset($_SESSION['message'])) {
            echo "<script>
            alert('{$_SESSION['message']}');
             window.location.href = '/login';
            </script>";
            unset($_SESSION['message']);
        }
        
        require __DIR__ . "/../../Views/login-form.php";
    }
}