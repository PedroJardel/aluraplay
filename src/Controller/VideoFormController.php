<?php
namespace alura\mvc\Controller;

use alura\mvc\Helper\HtmlRenderTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

class VideoFormController
{
    use HtmlRenderTrait;
    
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
        echo $this->renderTemplate(
            'video-form', 
            ['video' => $video]
        );
    }
}
