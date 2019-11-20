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
        id = :codigo
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

        <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
        <style>
            .div-titulo{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
        </style>
    </head>
    <body>
        <div class="container">    
            <br clear="both">
            <br clear="both">
            
            <div class="row div-titulo">
                <h1>Cadastro de Notícias</h1>
            </div>
            
            <br clear="both">
            <br clear="both">

            <form action="noticiaCRUD.php" method="POST">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $noticia['titulo'] ; ?>" class="form-control col-md-12" maxLength="255">
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" class="form-control col-md-12" maxLength="4000" ><?php echo $noticia['descricao'] ; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" id="slug" name="slug" value="<?php echo $noticia['slug'] ; ?>" class="form-control col-md-12" maxLength="50">
                </div>
                
                <input type="hidden" name="id" value="<?php echo $noticia['id']; ?>">

                <br clear="both">
                <br clear="both">

                <div class="clearfix">
                    <a href="/index.php" class="btn btn-light float-left col-md-2">
                        Cancelar
                    </a>
                    <input type="submit" class="btn btn-success float-right col-md-2" name="editar" value="Editar">
                </div>

                <br clear="both">
                <br clear="both">
                
            </form>
        </div>

        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>