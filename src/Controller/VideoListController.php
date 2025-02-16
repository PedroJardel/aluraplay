<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Repositories\VideoRepository;

class VideoListController implements ControllerInterface
{
    public function __construct(private VideoRepository $videoRepository) {}
    public function requestProcess(): void
    {
        $videosList = $this->videoRepository->getAll();
        require_once __DIR__ . "/../../Views/video-list.php";

        session_start();
        if (isset($_SESSION['message'])) {
            unset($_GET['success']);
            echo "<script>alert('{$_SESSION['message']}');</script>";
            unset($_SESSION['message']);
        }
    }
}
