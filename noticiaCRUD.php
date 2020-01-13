<?php
require_once('functions.php');

if (!empty($_POST['cadastrar'])) { 
    $slug = $_POST['slug'];
    $slug = explode("-", $slug);
    $ultimo = $slug[count($slug)-1];
    $ocorrencias = null;
    if (is_numeric($ultimo)) {
        $ocorrencias = $ultimo;
        unset($slug[count($slug)-1]);
    }

    $slug = join("-", $slug);

    $sql = '
        SELECT
            COUNT(*) total
        FROM
            noticia
        WHERE
            :where
    ';
    $where =  array(
        0 => 'slug = ":slug"',
        1 => ($ocorrencias == null) ? 'complemento IS NULL' : 'complemento = ":ocorrencia"',
    );

    $where = join(' AND ', $where);
    $sql = sf($sql, array(
        'where' => $where
    ));

    $slugs = db_select_one($sql, array(
        'slug' => $slug,
        'ocorrencia' => $ocorrencias,
    ));

    if (!empty($slugs['total'])) {
        $msg = '"'.$_POST['slug'].'" - Slug já cadastrado';
        header("location:cadastro.php?msg=$msg");
        exit;
    }

    $insert = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'slug' => $_POST['slug'],
    );

    if (!empty($complemento)) {
        $insert['complemento'] = $ocorrencias;
    }

    $cd_noticia = db_insert('noticia', $insert, true);
    
    header("location:/index.php");
    exit;
}

if (!empty($_POST['pesquisar'])) { 
    $sql = '
        SELECT
            n.*,
            IF(CONCAT(n.slug,"-",n.complemento) IS NOT NULL, CONCAT(n.slug,"-",n.complemento), n.slug) slug
        FROM
            noticia n
        WHERE
            n.id LIKE "%'.$_POST['termo'].'%" OR
            n.titulo LIKE "%'.$_POST['termo'].'%" OR
            n.descricao LIKE "%'.$_POST['termo'].'%" OR 
            n.slug LIKE "%'.$_POST['termo'].'%"
    ';
    $resultados = db_select($sql);
    monta_tabela(array(
        'titulo' => 'Título',
        'descricao' => 'Descrição',
        'slug' => 'Slug'
    ),$resultados, array(
        'chave' => 'id'
    ));
    exit;
}

if (!empty($_POST['editar'])) {
    $slug = $_POST['slug'];
    $slug = explode("-", $slug);
    $ultimo = $slug[count($slug)-1];
    $ocorrencias = null;
    if (is_numeric($ultimo)) {
        $ocorrencias = $ultimo;
        unset($slug[count($slug)-1]);
    }

    $slug = join("-", $slug);

    $sql = '
        SELECT
            COUNT(*) total
        FROM
            noticia
        WHERE
            :where
    ';
    $where =  array(
        0 => 'slug = ":slug"',
        1 => ($ocorrencias == null) ? 'complemento IS NULL' : 'complemento = ":ocorrencia"',
        2 => 'id != :id'
    );
    $where = join(' AND ', $where);
    $sql = sf($sql, array(
        'where' => $where
    ));

    $slugs = db_select_one($sql, array(
        'slug' => $slug,
        'ocorrencia' => $ocorrencias,
        'id' => $_POST['id']
    ));

    if (!empty($slugs['total'])) {
        $msg = '"'.$_POST['slug'].'" - Slug já cadastrado';
        header("location:editar.php?codigo={$_POST['id']}&msg=$msg");
        exit;
    }
    
    $update = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'slug' => $slug,
    );
    $where = array(
        'id' => $_POST['id']
    );
    db_update('noticia', $update, $where);    
    header("location:/detalhes.php?codigo={$_POST['id']}");
}

if (!empty($_GET['excluir'])) { 
    $where = array(
        'id' => $_GET['excluir']
    );
    db_delete('noticia', $where);
    header("location:/index.php");
}

if (!empty($_GET['consultar_slug'])) {
    $slug = $_GET['termo'];
    $slug = explode("-", $slug);
    $ultimo = $slug[count($slug)-1];
    $ocorrencias = null;
    if (is_numeric($ultimo)) {
        $ocorrencias = $ultimo;
        unset($slug[count($slug)-1]);
    }

    $slug = join("-", $slug);

    $sql = '
        SELECT
            COUNT(*) total
        FROM
            noticia
        WHERE
            :where
    ';
    $where =  array(
        0 => 'slug = ":slug"',
        1 => ($ocorrencias == null) ? 'complemento IS NULL' : 'complemento = ":ocorrencia"',
    );

    $where = join(' AND ', $where);
    $sql = sf($sql, array(
        'where' => $where
    ));

    $slugs = db_select_one($sql, array(
        'slug' => $slug,
        'ocorrencia' => $ocorrencias,
    ));

    if (!empty($slugs['total'])) {
        $sql = '
            SELECT
                COALESCE(MAX(complemento),0)+1 proximo
            FROM
                noticia
            WHERE
                slug = ":slug"
            LIMIT
                1
        ';                                                                                         

        $complemento = db_select_one($sql, array(
            'slug' => $slug
        ));
        $slug = $slug."-".$complemento['proximo'];
    }
    exit($slug);
}