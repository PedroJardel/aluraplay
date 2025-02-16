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
            session_start();
            $_SESSION['message'] = "Dados incorretos ou inexistentes";
            header("Location: /?success=0");
            exit();
        }
        
        $video = new Video (
            $url,
            $title
        );
        $video->setId($id);
        
        $result = $this->videoRepository->update($video);
        
        if (!$result) {
            session_start();
            $_SESSION['message'] = "Falha ao atualizar vídeo.";
            header("Location: /?success=0");
        } else {
            session_start();
            $_SESSION['message'] = "Vídeo atualizado com sucesso.";
            header("Location: /?success=1");
        }

    }
}