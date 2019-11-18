<?php
require_once('functions.php');

if (!empty($_POST['cadastrar'])) { 
    $insert = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'slug' => $_POST['slug']
    );
    db_insert('noticia', $insert);
    header("location:/index.php");
}

if (!empty($_POST['pesquisar'])) { 
    $sql = '
        SELECT
            *
        FROM
            noticia
        WHERE
            id LIKE "%'.$_POST['termo'].'%" OR
            titulo LIKE "%'.$_POST['termo'].'%" OR
            descricao LIKE "%'.$_POST['termo'].'%" OR 
            slug LIKE "%'.$_POST['termo'].'%"
    ';
    $resultados = db_select($sql);
    monta_tabela(array(
        'id' => 'Código',
        'titulo' => 'Título',
        'descricao' => 'Descrição',
        'slug' => 'Slug'
    ),$resultados, array(
        'chave' => 'id'
    ));
    exit;
}

if (!empty($_POST['editar'])) { 
    $insert = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'slug' => $_POST['slug']
    );
    db_insert('noticia', $insert);
    header("location:/detalhes.php");
}

if (!empty($_POST['excluir'])) { 
    $insert = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'slug' => $_POST['slug']
    );
    db_insert('noticia', $insert);
    header("location:/index.php");
}
