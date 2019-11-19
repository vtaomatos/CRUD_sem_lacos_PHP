<?php
require_once('functions.php');

?>

<style>
    .div-titulo{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>

<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css" />
<div class="container">    
    <br clear="both">
    <br clear="both">
    
    <div class="row div-titulo">
        <h1>Pesquisa de Notícias</h1>
    </div>
    
    <br clear="both">
    <br clear="both">

    <form action="index.php" method="POST">
        <div class="form-group">
            <label for="titulo">Id:</label> 
            <input type="text" id="id" name="id" class="form-control col-md-12" maxLength="8">
        </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" class="form-control col-md-12" maxLength="255">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" class="form-control col-md-12" maxLength="4000"></textarea>
        </div>
        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" id="slug" name="slug" class="form-control col-md-12" maxLength="50">
        </div>

        <br clear="both">
        <br clear="both">

        <div class="clearfix">
            <a href="/index.php" class="btn btn-light float-left col-md-2">
                Listagem
            </a>
            <input type="submit" class="btn btn-success float-right col-md-2" name="pesquisar" value="Pesquisar">
        </div>

        <br clear="both">
        <br clear="both">
        
    </form>
</div>

<script src="bootstrap/dist/js/bootstrap.min.js"></script>