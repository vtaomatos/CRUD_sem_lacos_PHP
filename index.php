<?php
require_once('functions.php');

$consulta = "SELECT * FROM noticia";
$noticias = db_select($consulta, true);

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>
            CNSL - CURD Notícias Sem Laços
        </title>

        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
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

            <form class="offset-md-6 col-md-6">
                <div class="clearfix filtro">
                    <label for="pesquisa" class="col-md-3">Filtro:</label>
                    <div class="col-md-9 float-right">
                        <input type="text" id="pesquisa" name="pesquisa" onkeyup="noticia.pesquisa(this.value);" class="form-control form-control-sm">
                    </div>
                </div>
            </form>

            <br clear="both">

            <div class="div-tabela">
                <?php monta_tabela($noticias,'title'); ?>
            </div>

            <br clear="both">
            <br clear="both">

            <div class="clearfix">
                <a href="/cadastro.php" class="btn btn-light float-left">
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
            var noticia = {
                pesquisa : function (texto) {
                    var request = jQuery.ajax({
                        method: "POST",
                        url: "noticiaCRUD.php",
                        data: {termo: texto, pesquisar: 1}
                    });
                    request.done(function(tabela){
                        $(".div-tabela").html(tabela);
                    });
                }
            }
        </script>
    </body>
</html>