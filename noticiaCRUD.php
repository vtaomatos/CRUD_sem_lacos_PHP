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
            slug
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
        'id_slug' => $id_slug
    ));

    if (!empty($slugs['total'])) {
        $msg = '"'.$_POST['slug'].'" - Slug já cadastrado';
        header("location:cadastro.php?msg=$msg");
        exit;
    }
    
    $insert = array (
        'slug' => $_POST['slug']
    );
    $cd_slug = db_insert('slug', $insert, true);
    
    $insert = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'id_slug' => $cd_slug
    );
    db_insert('noticia', $insert);
    header("location:/index.php");
}

if (!empty($_POST['pesquisar'])) { 
    $sql = '
        SELECT
            n.*,
            s.*,
            IF(CONCAT(s.slug,"-",s.complemento) IS NOT NULL, CONCAT(s.slug,"-",s.complemento), s.slug) slug
        FROM
            noticia n
        INNER JOIN
            slug s ON s.id_slug = n.id_slug
        WHERE
            n.id LIKE "%'.$_POST['termo'].'%" OR
            n.titulo LIKE "%'.$_POST['termo'].'%" OR
            n.descricao LIKE "%'.$_POST['termo'].'%" OR 
            s.slug LIKE "%'.$_POST['termo'].'%"
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
    $id_slug = $_POST['id_slug'];
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
            slug
        WHERE
            :where
    ';
    $where =  array(
        0 => 'slug = ":slug"',
        1 => ($ocorrencias == null) ? 'complemento IS NULL' : 'complemento = ":ocorrencia"',
        2 => 'id_slug != :id_slug'
    );
    $where = join(' AND ', $where);
    $sql = sf($sql, array(
        'where' => $where
    ));

    $slugs = db_select_one($sql, array(
        'slug' => $slug,
        'ocorrencia' => $ocorrencias,
        'id_slug' => $id_slug
    ));

    if (!empty($slugs['total'])) {
        $msg = '"'.$_POST['slug'].'" - Slug já cadastrado';
        header("location:editar.php?codigo={$_POST['id']}&msg=$msg");
        exit;
    }
    
    if (!empty($_POST['id_slug'])) {
        $where = array(
            'id_slug' => $id_slug
        );
        $update = array(
            'slug' => $slug,
        );
        if ($ocorrencias != null) {
            $update['complemento'] =  $ocorrencias;
        } else {
            $update['complemento'] = NULL;
        }

        db_update('slug', $update, $where, true);
    } else {
        $insert = array(
            'slug' => $slug
        );
        $id_slug = db_insert('slug', $insert, true);
    }
    
    $update = array(
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'id_slug' => $id_slug
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
            slug
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
        // 'id_slug' => $id_slug
    ));

    if (!empty($slugs['total'])) {
        $sql = '
            SELECT
                MAX(complemento)+1 proximo
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
        $slug = $slug."-".$complemento['total'];
    } else {
        $slug = $slug."-".$complemento;
    }
    return($slug);

}