<?php
require_once('functions.php');

$sql = '
    SELECT
        n.id,
        n.titulo,
        n.descricao,
        IF(CONCAT(s.slug,"-",s.complemento) IS NOT NULL, CONCAT(s.slug,"-",s.complemento), s.slug) slug,
        s.id_slug
    FROM
        noticia n
    LEFT JOIN 
        slug s ON s.id_slug = n.id_slug
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
        <script src="js/jquery-3.4.1.js"></script>
        <style>
            .div-titulo{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .sug-slug-title{
                color:red;
                font-weight:bold;
            }
            .sug-slug-description{
                font-weight:bold;
            }
            .slug-infos{
                display:flex;
                flex-direction:row;
                justify-content:space-between;
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

            <?php if (!empty($_GET['msg'])) { ?>
                <div class="alert alert-danger"><?php echo $_GET['msg']; ?></div>
            <?php } ?>

            <form action="noticiaCRUD.php" method="POST">
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" onkeyup="gera_slug(this.value);" value="<?php echo $noticia['titulo'] ; ?>" class="form-control col-md-12" maxLength="255">
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea name="descricao" id="descricao" class="form-control col-md-12" maxLength="4000" rows="7"><?php echo $noticia['descricao'] ; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" id="slug" name="slug" value="<?php echo $noticia['slug'] ; ?>" class="form-control col-md-12" maxLength="50">
                </div>
                <div class="slug-infos">
                    <span class="sug-slug-title">Sugestão de Slug: </span><span id="sug-slug" class="sug-slug-description"></span>
                    <button type="button" id="aceita-sugestao" class="btn btn-primary col-md-3" disabled>Aceitar sugestão de slug</button>
                </div>
                <input type="hidden" name="id" value="<?php echo $noticia['id']; ?>">
                <input type="hidden" name="id_slug" value="<?php echo $noticia['id_slug'] ; ?>">

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
        <script>
            if (!String.prototype.slugify) {
                String.prototype.slugify = function () {

                return  this.toString().toLowerCase()
                .replace(/[àÀáÁâÂãäÄÅåª]+/g, 'a')       // Special Characters #1
                .replace(/[èÈéÉêÊëË]+/g, 'e')       	// Special Characters #2
                .replace(/[ìÌíÍîÎïÏ]+/g, 'i')       	// Special Characters #3
                .replace(/[òÒóÓôÔõÕöÖº]+/g, 'o')       	// Special Characters #4
                .replace(/[ùÙúÚûÛüÜ]+/g, 'u')       	// Special Characters #5
                .replace(/[ýÝÿŸ]+/g, 'y')       		// Special Characters #6
                .replace(/[ñÑ]+/g, 'n')       			// Special Characters #7
                .replace(/[çÇ]+/g, 'c')       			// Special Characters #8
                .replace(/[ß]+/g, 'ss')       			// Special Characters #9
                .replace(/[Ææ]+/g, 'ae')       			// Special Characters #10
                .replace(/[Øøœ]+/g, 'oe')       		// Special Characters #11
                .replace(/[%]+/g, 'pct')       			// Special Characters #12
                .replace(/\s+/g, '-')           		// Replace spaces with -
                .replace(/[^\w\-]+/g, '')       		// Remove all non-word chars
                .replace(/\-\-+/g, '-')         		// Replace multiple - with single -
                .replace(/^-+/, '')             		// Trim - from start of text
                .replace(/-+$/, '');            		// Trim - from end of text
                
                };
            }
            function gera_slug (valor) {
                var request = jQuery.ajax({
                    method: "GET",
                    url: "noticiaCRUD.php",
                    data: {termo: valor.slugify(), consultar_slug: 1}
                });
                request.done(function(resultado){
                    $("#sug-slug").html(resultado);
                    if (resultado.length > 0) {
                        $("#aceita-sugestao").prop("disabled",false);
                    } else {
                        $("#aceita-sugestao").prop("disabled", true);
                    }
                });
            }

            $("#aceita-sugestao").click(function () {
                if (confirm("Alterar o slug?")) {
                    $("#slug").val($("#sug-slug").html());
                    $("#sug-slug").html("");
                }
            });



        </script>
    </body>
</html>