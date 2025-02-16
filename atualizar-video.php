<?php

use alura\mvc\Models\Video;
use alura\mvc\Repositories\VideoRepository;

require "connection-database.php";

$url = filter_input(INPUT_POST, "url", FILTER_VALIDATE_URL);
$title = filter_input(INPUT_POST, "title");
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$data = [$id, $url, $title ];

if (count(array_intersect($data, [false, true])) > 0) {
    session_start();
    $_SESSION['message'] = "Dados incorretos ou inexistentes";
    header("Location: /?success=0");
    exit();
}

$video = new Video (
    $url,
    $title
);
$video->setId($id);

$videoRepository = new VideoRepository($connection);
$result = $videoRepository->update($video);

if ($result === false) {
    session_start();
    $_SESSION['message'] = "Falha ao atualizar vídeo.";
    header("Location: /?success=0");
} else {
    session_start();
    $_SESSION['message'] = "Vídeo atualizado com sucesso.";
    header("Location: /?success=1");
}
