<?php
namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveThumbController implements ControllerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
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
        $result = $this->videoRepository->removeThumb($id);

        if (!$result) {
            $this->addErrorMessage("Falha ao remover thumb do vídeo.");
            return new Response(
                302,
                [
                    'Location' => '/'
                ]
            );
        } else {
             $this->addSuccessMessage("Thumb removida com sucesso.");
             return new Response(
                302,
                [
                    'Location' => '/'
                ]
            );
        }
    }
}