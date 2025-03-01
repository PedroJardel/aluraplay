<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Repositories\VideoRepository;

class VideoListController extends ControllerWithHtml
{
    public function __construct(private VideoRepository $videoRepository) {}
    public function requestProcess(): void
    {

        if (array_key_exists('message', $_SESSION)) {
            echo "<script>
            alert('{$_SESSION['message']}');
             window.location.href = '/';
            </script>";
            unset($_SESSION['message']);
        }

        $videoList = $this->videoRepository->getAll();
        $this->renderTemplate(
            'video-list',
            ['videoList' => $videoList]
        );
    }
}