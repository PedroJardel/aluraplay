<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use finfo;

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

        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $safeFileName = uniqid('upload_') . '_' . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['image']['tmp_name']);

            if(str_starts_with($mimeType, 'image/')) {
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . "/../../public/img/uploads/" . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }
        $result = $this->videoRepository->add($video);

        if (!$result) {
            $_SESSION['message'] = "Falha ao adicionar vídeo.";
            header("Location: /?success=0");
        } else {
            $_SESSION['message'] = "Vídeo adicionado com sucesso.";
            header("Location: /?success=1");
        } 
    }
}
