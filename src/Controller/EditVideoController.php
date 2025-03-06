<?php
namespace alura\mvc\Controller;

use alura\mvc\Helper\FlashMessageTrait;
use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository){}    

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $queryParams = $request->getQueryParams();
        $url = filter_var($body['url'],FILTER_VALIDATE_URL);
        $title = filter_var($body['title']);
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        
        $data = [$id, $url, $title ];

        if (count(array_intersect($data, [false, true])) > 0) {
            $this->addErrorMessage("Dados incorretos ou inexistentes");
            return new Response (302,
            [
                'Location' => '/'
            ]);
        }
        
        $video = new Video (
            $url,
            $title
        );
        $files = $request->getUploadedFiles();
        /**
         * @var \Psr\Http\Message\UploadedFileInterface $uploadedImage
         */
        $uploadedImage = $files['image'];

        if($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if(str_starts_with($mimeType, 'image/')) {
                $fileName = uniqid('upload') . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . "/../../public/img/uploads/" . $fileName);
                $video->setFilePath($fileName);
            }
        }
        $video->setId($id);

        $result = $this->videoRepository->update($video);
        
        if (!$result) {
            $this->addErrorMessage("Falha ao atualizar vídeo.");
            return new Response (302,
            [
                'Location' => '/'
            ]);
        } else {
            $this->addSuccessMessage("Vídeo atualizado com sucesso.");
            return new Response (302,
            [
                'Location' => '/'
            ]);
        }

    }
}