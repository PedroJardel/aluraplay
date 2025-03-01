<?php
namespace alura\mvc\Controller;

use alura\mvc\Helper\HtmlRenderTrait;
use alura\mvc\Repositories\VideoRepository;

class VideoListController
{
    use HtmlRenderTrait;
    public function __construct(private VideoRepository $videoRepository) {}
    public function requestProcess(): void
    {
        $videoList = $this->videoRepository->getAll();
        echo $this->renderTemplate(
            'video-list',
            ['videoList' => $videoList]
        );
    }
}