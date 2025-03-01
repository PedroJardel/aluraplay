<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewJsonVideoController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
        
    }

    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        $request = $request->getBody()->getContents();
        $videoData = json_decode($request, true);
        $video = new Video(
            $videoData['url'],
            $videoData['title']
        );
        $this->videoRepository->add($video);

        return new Response (201);
    }
}