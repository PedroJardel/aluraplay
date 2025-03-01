<?php

namespace alura\mvc\Controller;

use alura\mvc\Helper\HtmlRenderTrait;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoListController
{
    use HtmlRenderTrait;
    public function __construct(private VideoRepository $videoRepository) {}
    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->getAll();
        return new Response(
            200,
            body: $this->renderTemplate(
                'video-list',
                ['videoList' => $videoList]
            )
        );
    }
}
