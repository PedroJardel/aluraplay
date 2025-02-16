<?php
require_once __DIR__ . "/Base/inicio-html.php";
?>
<main class="container">
    <form class="container__formulario"
        method="post">
        <h2 class="formulario__titulo">Envie um vídeo!</h3>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="url">Link embed</label>
                <input name="url"
                    value="<?= $video?->url ?>"
                    class="campo__escrita"
                    required
                    type="url"
                    pattern="https?://.+"
                    placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g" id='url' />
            </div>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="title">Titulo do vídeo</label>
                <input name="title"
                    value="<?= $video?->title ?>"
                    class="campo__escrita"
                    required
                    placeholder="Neste campo, dê o nome do vídeo"
                    id='title' />
            </div>
            <input class="formulario__botao" type="submit" value="Enviar" />
    </form>
</main>
<?php require_once __DIR__ . "/Base/fim-html.php";
