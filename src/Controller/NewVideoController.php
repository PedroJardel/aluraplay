<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use finfo;

session_start();

class NewVideoController implements ControllerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess(array $data = ["url", "title"]): void
    {
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage("URL inválida");
            header("Location: /novo-video");
            exit();
        }

        $title = filter_input(INPUT_POST, "title");
        if ($title === false) {
            $this->addErrorMessage("Titulo não informado");
            header("Location: /novo-video");
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
            $this->addErrorMessage("Falha ao adicionar vídeo.");
            header("Location: /novo-video");
        } else {
            $this->addSuccessMessage("Vídeo adicionado com sucesso.");
            header("Location: /");
        } 
    }
}
