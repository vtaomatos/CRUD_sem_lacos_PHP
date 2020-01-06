<?php
require_once('functions.php');
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
            
            <?php if (!empty($_GET['msg'])) { ?>
                <div class="alert alert-danger"><?php echo $_GET['msg']; ?></div>
            <?php } ?>

            <form action="noticiaCRUD.php" method="POST">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" class="form-control col-md-12" maxLength="255">
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" class="form-control col-md-12" maxLength="4000" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control col-md-12" maxLength="50">
                </div>
                
                <br clear="both">
                <br clear="both">

                <div class="clearfix">
                    <a href="/index.php" class="btn btn-light float-left col-md-2">
                        Cancelar
                    </a>
                    <input type="submit" class="btn btn-success float-right col-md-2" name="cadastrar" value="Cadastrar">
                </div>

                <br clear="both">
                <br clear="both">
                
            </form>
        </div>

        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>