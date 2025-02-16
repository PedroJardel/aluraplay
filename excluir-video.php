<?php

use alura\mvc\Repositories\VideoRepository;

require_once "connection-database.php";

$videoRepository = new VideoRepository($connection);
$id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);

if(in_array($id, [false, null], true)) {
    session_start();
    $_SESSION['message'] = "Identificador incorreto ou inexistente na requisição";
    header("Location: /?success=0");
    exit();
}
$result = $videoRepository->remove($id);

if (!$result) {
    session_start();
    $_SESSION['message'] = "Falha ao excluir vídeo.";
    header("Location: /?success=0");
} else {
    session_start();
    $_SESSION['message'] = "Vídeo excluido com sucesso.";
    header("Location: /?success=1");
}
