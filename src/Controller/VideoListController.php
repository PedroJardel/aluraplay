<?php

namespace alura\mvc\Controller;

use alura\mvc\Repositories\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface
{
    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates,
        ) {}
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->getAll();
        return new Response(
            200,
            body: $this->templates->render(
                'video-list',
                ['videoList' => $videoList]
            )
        );
    }
}
