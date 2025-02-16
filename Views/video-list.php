<?php
require_once __DIR__ . "/Base/inicio-html.php"; 
?>
<ul class="videos__container" alt="videos alura">
    <?php foreach ($videosList as $video): ?>
        <li class="videos__item">
            <iframe width="100%" height="72%" src="<?= $video->url ?>"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
            <div class="descricao-video">
                <img src="./img/logo.png" alt="logo canal alura">
                <h3><?= $video->title ?></h3>
                <div class="acoes-video">
                    <a href="/atualizar-video?id=<?= $video->id ?>">Editar</a>
                    <a href="/excluir-video?id=<?= $video->id ?>">Excluir</a>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
<?php require_once __DIR__ . "/Base/fim-html.php";
