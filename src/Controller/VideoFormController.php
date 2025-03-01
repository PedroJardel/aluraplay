<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class VideoFormController extends ControllerWithHtml
{
    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        /**
         * @var ?Video $video
         */
        $video = null;

        if (!in_array($id, [false, null], true)) {
            $video = $this->videoRepository->getById($id);
        }
        $this->renderTemplate(
            'video-form', 
            ['video' => $video]
        );
    }
}
