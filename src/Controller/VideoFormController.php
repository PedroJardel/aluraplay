<?php

namespace alura\mvc\Controller;

use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Helper\HtmlRenderTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoFormController
{
    use HtmlRenderTrait;
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        /** @var ?Video $video */
        $video = null;

        if ($queryParams['id']) {
            $id = filter_var($queryParams['id'], FILTER_SANITIZE_NUMBER_INT);
            if (in_array($id, [false, null], true)) {
                $this->addErrorMessage("Identificador incorreto ou inexistente na requisição");
                return new Response(
                    302,
                    [
                        'Location' => '/'
                    ]
                );
            }
            $video = $this->videoRepository->getById($id);
        }
        
        return new Response(
            200,
            body: $this->renderTemplate(
                'video-form',
                ['video' => $video]
            )
        );
    }
}
