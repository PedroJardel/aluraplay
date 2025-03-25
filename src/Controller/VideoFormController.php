<?php

namespace alura\mvc\Controller;

use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates,
        ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
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
            body: $this->templates->render(
                'video-form',
                ['video' => $video]
            )
        );
    }
}
