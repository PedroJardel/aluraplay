<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class EditVideoController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository){}    

    public function requestProcess()
    {
        $url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
        $title = filter_input(INPUT_POST, "title");
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        
        $data = [$id, $url, $title ];

        if (count(array_intersect($data, [false, true])) > 0) {
            $_SESSION['message'] = "Dados incorretos ou inexistentes";
            header("Location: /?success=0");
            exit();
        }
        
        $video = new Video (
            $url,
            $title
        );

        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid('upload') . $_FILES['image']['name'];
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . "/../../public/img/uploads/" . $fileName
            );
            $video->setFilePath($fileName);
        }
        $video->setId($id);

        $result = $this->videoRepository->update($video);
        
        if (!$result) {
            $_SESSION['message'] = "Falha ao atualizar vídeo.";
            header("Location: /?success=0");
        } else {
            $_SESSION['message'] = "Vídeo atualizado com sucesso.";
            header("Location: /?success=1");
        }

    }
}