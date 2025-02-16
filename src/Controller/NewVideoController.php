<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class NewVideoController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess(array $data = ["url", "title"]): void
    {
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, "title");

        $data = [$url, $title];
        if (count(array_intersect($data, [false, true])) > 0) {
            session_start();
            $_SESSION['message'] = "Dados incorretos ou inexistentes";
            header("Location: /?success=0");
            exit();
        }

        $video = new Video(
            $url,
            $title,
        );

        $result = $this->videoRepository->add($video);

        if (!$result) {
            session_start();
            $_SESSION['message'] = "Falha ao adicionar vídeo.";
            header("Location: /?success=0");
        } else {
            session_start();
            $_SESSION['message'] = "Vídeo adicionado com sucesso.";
            header("Location: /?success=1");
        } 
    }
}
