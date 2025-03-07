<?php

namespace alura\mvc\Controller;

use alura\mvc\Helper\FlashMessageTrait;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    private PDO $connection;
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $email = filter_var($body['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($body['password']);

        $sql = "SELECT * FROM users WHERE email = :email";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue("email", $email, PDO::PARAM_STR);
        $statement->execute();

        $userData = $statement->fetch();

        $correctPassword = password_verify($password, $userData['password'] ?? '');

        if (!$correctPassword) {
            $this->addErrorMessage("Email ou senha inválidos");
            return new Response ( 302,
            [
                'Location' => '/login'
            ]);
        }

        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
            $statement = $this->connection->prepare("UPDATE users SET password = :password WHERE id = :id");
            $statement->bindValue("password", password_hash($password, PASSWORD_ARGON2ID), PDO::PARAM_STR);
            $statement->bindValue("id", $userData['id']);
            $statement->execute();
        }
        $_SESSION["logado"] = true;
        return new Response(
            302,
            [
                'Location' => '/'
            ]);
    }
}
