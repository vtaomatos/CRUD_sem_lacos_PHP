<?php
require_once('functions.php');


$condicao = array(
    '1=1'
);

if (!empty($_POST['pesquisar'])) {
    $filtrado = false;
    if (!empty($_POST['id'])) {
        $condicao[] = 'n.id = "'.$_POST['id'].'"';
        $filtrado = true;
    }
    if (!empty($_POST['titulo'])) {
        $condicao[] = 'n.titulo LIKE "%'.$_POST['titulo'].'%"';
        $filtrado = true;
    }
    if (!empty($_POST['descricao'])) {
        $condicao[] = 'n.descricao LIKE "%'.$_POST['descricao'].'%"';
        $filtrado = true;
    }
    if (!empty($_POST['slug'])) {
        $slug = $_POST['slug'];
        $slug = explode("-", $slug);
        $ultimo = $slug[count($slug)-1];
        $ocorrencias = 0;
        if (is_numeric($ultimo)) {
            $ocorrencias = $ultimo;
            unset($slug[count($slug)-1]);
        }
        $slug = join("-", $slug);

        $condicao[] = 's.slug LIKE "%'.$slug.'%"';
        $condicao[] = 's.complemento LIKE "%'.$ocorrencias.'%"';
        $filtrado = true;
    }
}
$condicao = join(" AND ", $condicao);

$consulta = '
    SELECT 
        n.*,
        s.*,
        IF(CONCAT(s.slug,"-",s.complemento) IS NOT NULL, CONCAT(s.slug,"-",s.complemento), s.slug) slug
    FROM
        noticia n
    LEFT JOIN
        slug s ON s.id_slug = n.id_slug
    WHERE
        :condicao
';
$noticias = db_select($consulta, array(
    'condicao' => $condicao
));


?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>
            CNSL - CURD Notícias Sem Laços
        </title>

        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <style>
            .div-tabela{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .div-titulo{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .filtro{
                text-align:right;
            }
            .btn-detalhes{
                color:inherit;
            }
            #mostrar-todos{
                display:none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br clear="both">
            <br clear="both">

            <div class="row div-titulo">
                <h1>Listagem de Notícias</h1>
            </div>

            <br clear="both">
            <br clear="both">

            <form class="offset-md-4 col-md-8">
                <div class="clearfix filtro">
                    <button href="index.php" id="mostrar-todos" class="btn btn-secondary col-md-3">Mostrar Todos</button>
                    <label for="pesquisa" class="col-md-2">Filtro:</label>
                    <div class="col-md-6 float-right">
                        <input type="text" id="pesquisa" name="pesquisa" onkeyup="noticia.pesquisa(this.value);" class="form-control form-control-sm">
                    </div>
                </div>
            </form>

            <br clear="both">

            <div class="div-tabela">
                <?php monta_tabela(array(
                    'titulo' => 'Título',
                    'descricao' => 'Descrição',
                    'slug' => 'Slug'
                ), $noticias,array(
                    'title' => "Título: :titulo \n\nDescrição: :descricao",
                    'chave' => 'id'
                )); ?>
            </div>

            <br clear="both">
            <br clear="both">

            <div class="clearfix">
                <a href="/pesquisa.php" class="btn btn-light float-left">
                    Pesquisar
                </a>
                <a href="/cadastro.php" class="btn btn-primary float-right">
                    Nova notícia
                </a>
            </div>
            <br clear="both">
            <br clear="both">
        </div>

        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/jquery-3.4.1.js"></script>

        <script>
            if (($("#pesquisa").val() == "") && ("<?php echo !empty($_POST['pesquisar']) ? $_POST['pesquisar'] : "0" ?>" != "Pesquisar")) {
                $("#mostrar-todos").hide();
            } else {
                $("#mostrar-todos").show();
            }
            var noticia = {
                pesquisa : function (texto) {
                    var request = jQuery.ajax({
                        method: "POST",
                        url: "noticiaCRUD.php",
                        data: {termo: texto, pesquisar: 1}
                    });
                    request.done(function(tabela){
                        $(".div-tabela").html(tabela);
                        if (($("#pesquisa").val() == "") && ("<?php echo !empty($_POST['pesquisar']) ? $_POST['pesquisar'] : "0" ?>" != "Pesquisar")) {
                            $("#mostrar-todos").hide();
                        } else {
                            $("#mostrar-todos").show();
                        }
                    });
                }
            }
        </script>
    </body>
</html>