<?php
namespace alura\mvc\Controller;

use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JsonVideoListController implements RequestHandlerInterface
{

    public function __construct(private VideoRepository $videoRepository)
    {
        
    }
 public function handle(ServerRequestInterface $request): ResponseInterface
 {
    $videoList = array_map(function (Video $video): array {
        return [
            'url' => $video->url,
            'title' => $video->title,
            'file_path' => $video->filePath()
        ];
    }, $this->videoRepository->getAll());
    return new Response (200, 
    [
        'Content-type' => 'application/json'
    ], json_encode($videoList));
 }
}