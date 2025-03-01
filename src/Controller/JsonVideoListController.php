<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class JsonVideoListController implements ControllerInterface
{

    public function __construct(private VideoRepository $videoRepository)
    {
        
    }
 public function requestProcess()
 {
    $videoList = array_map(function (Video $video): array {
        return [
            'url' => $video->url,
            'title' => $video->title,
            'file_path' => $video->filePath()
        ];
    }, $this->videoRepository->getAll());
    echo json_encode($videoList);
 }
}