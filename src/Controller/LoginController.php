<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Infra\Database;
use PDO;

class LoginController implements ControllerInterface
{
    use FlashMessageTrait;
    private PDO $connection;
    public function __construct()
    {
        $this->connection = Database::getConnection();
    }
    public function requestProcess()
    {
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");

        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("email", $email, PDO::PARAM_STR);
        $statement->execute();

        $userData = $statement->fetch();

        $correctPassword = password_verify($password, $userData['password'] ?? '');

        if ($correctPassword) {
            if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
                $statement = $this->connection->prepare("UPDATE users SET password = :password WHERE id = :id");
                $statement->bindValue("password", password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
                $statement->bindValue("id", $userData['id']);
                $statement->execute();
            }
            $_SESSION["logado"] = true;
            header("Location: /");
        } else {
            $this->addErrorMessage("Dados incorretos");
            header("Location: /login");
        }
    }
}
