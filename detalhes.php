<?php
require_once('functions.php');

$sql = '
    SELECT
        n.id,
        n.titulo,
        n.descricao,
        IF(CONCAT(n.slug,"-",n.complemento) IS NOT NULL, CONCAT(n.slug,"-",n.complemento), n.slug) slug
    FROM
        noticia n
    WHERE
        n.id = ":codigo"
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
        <script src="js/jquery-3.4.1.js"></script>
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
            <a href="#modal" data-toggle="modal" data-target="#myModal" class="btn btn-danger float-right col-md-2">
                Excluir
            </a>
            <a href="/editar.php?codigo=<?php echo $noticia['id']; ?>" id="excluir" class="btn btn-success float-right col-md-2">
                Editar
            </a>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir registro</h4>
                    </div>
                    <div class="modal-body">
                        <p>Ao confirmar, esse registro será removido.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="location.href='noticiaCRUD.php?excluir=<?php echo $noticia['id']; ?>'">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>