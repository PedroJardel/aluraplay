<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Repositories\VideoRepository;

class DeleteVideoController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

        if (in_array($id, [false, null], true)) {
            session_start();
            $_SESSION['message'] = "Identificador incorreto ou inexistente na requisição";
            header("Location: /?success=0");
            exit();
        }
        $result = $this->videoRepository->remove($id);

        if (!$result) {
            session_start();
            $_SESSION['message'] = "Falha ao excluir vídeo.";
            header("Location: /?success=0");
        } else {
            session_start();
            $_SESSION['message'] = "Vídeo excluido com sucesso.";
            header("Location: /?success=1");
        }
    }
}
