<?php
require_once('functions.php');

$sql = '
    SELECT
        id,
        titulo,
        descricao,
        slug
    FROM
        noticia
    WHERE
        id = ":codigo"
';

$noticia = db_select_one($sql, array(
    'codigo' => !empty($_GET['codigo']) ? $_GET['codigo'] : ""
));

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>
            CNSL - CURD Notícias Sem Laços
        </title>
        <style>
            .div-titulo{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .div-corpo{
                min-height:200px;
                font-size:20px;
            }
            .div-slug{
                font-weight:bold;
            }
            .slug{
                margin-right:10px;
            }
        </style>

        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container">    
            <br clear="both">
            <br clear="both">
            
            <div class="row div-titulo">
                <h1><?php echo $noticia['titulo']; ?></h1>
            </div>
            <br clear="both">
            <br clear="both">
            <div class="row div-corpo alert alert-light">
                <?php echo $noticia['descricao']; ?>
            </div>
            <br clear="both">
            <br clear="both">
            <div class="row div-slug alert alert-primary">
                <span class="slug">SLUG: </span><?php echo $noticia['slug']; ?>
            </div>
            

            <br clear="both">
            <br clear="both">

            <a href="/index.php" class="btn btn-light float-left col-md-2">
                Listagem
            </a>
            <a href="/editar.php?codigo=<?php echo $noticia['id']; ?>" class="btn btn-success float-right col-md-2">
                Editar
            </a>
        </div>

        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>