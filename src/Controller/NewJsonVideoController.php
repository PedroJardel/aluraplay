<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class NewJsonVideoController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
        
    }

    public function requestProcess()
    {
        $request = file_get_contents('php://input');
        $videoData = json_decode($request, true);
        $video = new Video(
            $videoData['url'],
            $videoData['title']
        );
        $this->videoRepository->add($video);

        http_response_code(201);
    }
}