<?php

namespace alura\mvc\Controller;

use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_SANITIZE_NUMBER_INT);

        if (in_array($id, [false, null], true)) {
            $this->addErrorMessage("Identificador incorreto ou inexistente na requisição");
            return new Response(302, 
        [
            'Location' => '/'
        ]);
        }
        $result = $this->videoRepository->remove($id);

        if (!$result) {
            $this->addErrorMessage("Falha ao excluir vídeo.");
            return new Response(302, 
            [
                'Location' => '/'
            ]);
        } else {
            $this->addSuccessMessage("Vídeo excluido com sucesso.");
            return new Response(302, 
            [
                'Location' => '/'
            ]);
        }
    }
}
