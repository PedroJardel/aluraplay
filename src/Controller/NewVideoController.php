<?php

namespace alura\mvc\Controller;

use alura\mvc\Controller\Interfaces\ControllerInterface;
use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

session_start();

class NewVideoController implements ControllerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository) {}

    public function requestProcess(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage("URL inválida");
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        }

        $title = filter_var($body['title']);
        if ($title === false) {
            $this->addErrorMessage("Titulo não informado");
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        }

        $video = new Video(
            $url,
            $title,
        );

        $files = $request->getUploadedFiles();
        /**
         * @var \Psr\Http\Message\UploadedFileInterface $uploadedImage
         */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . "/../../public/img/uploads/" . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }
        $result = $this->videoRepository->add($video);

        if (!$result) {
            $this->addErrorMessage("Falha ao adicionar vídeo.");
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        } else {
            $this->addSuccessMessage("Vídeo adicionado com sucesso.");
            return new Response(
                302,
                [
                    'Location' => '/'
                ]
            );
        }
    }
}
