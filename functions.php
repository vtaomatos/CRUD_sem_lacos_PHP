<?php

$conexao = mysqli_connect('localhost','root','', 'teste_backsite');


function get_conexao() {
    global $conexao;
    return $conexao;
}

function db_select($comando,$cabecalho=false) {
    $resultado = mysqli_query(get_conexao(), $comando);
    $saida = mysqli_fetch_all($resultado);

    if (!empty($cabecalho)) {
        array_unshift($saida,campos($resultado));
    }

    array_walk_recursive($saida, function(&$item){
        $item = utf8_encode($item);
    });

    return $saida;
}

function db_select_one($comando,$cabecalho=false) {
    $retorno = db_select($comando,$cabecalho);
    print_r($retorno);
    if (count($retorno) == 1) {
        $retorno = array_shift($retorno);
    } else {
        $retorno = false;
    }
    return $retorno;
}

function campos($resultado){
    $saida = mysqli_fetch_fields($resultado);
    array_walk($saida, function (&$campo) {
        $campo = $campo->name;
    });
    return $saida;
}

function get_colunas($colunas) {
    array_map(function ($coluna) {
        echo "<td>";
        echo $coluna;
        echo "</td>";
    }, $colunas);
    echo "<td>";
    echo '<a href="detalhes.php?codigo='.$colunas[0].'"><i class="material-icons">face</i></a>';
    echo "</td>";
}

function get_linhas($tabela){
    $saida = array_map(function ($linha) {
        echo '<tr title="Tíitulo: '.$linha[1]. "\n\nDescrição: " . $linha[2].'">';
        get_colunas($linha);
        echo '</tr>';
        return 1;
    }, $tabela);
    return !empty($saida);
}

function get_cabeacalho(&$tabela) {
    $cabecalho = array_shift($tabela);
    $array_cabecalho = array(count($cabecalho), $cabecalho);
    return $array_cabecalho;
}

function monta_cabecalho(&$tabela) {
    $cabecalho = get_cabeacalho($tabela);
    echo '<thead class="thead-dark">';
    echo '<tr>';
    array_map(function ($campo) {
        echo "<th>";
        echo ucfirst($campo);
        echo "</th>";
    }, $cabecalho[1]);
    echo "<th>";
    echo " ";
    echo "</th>";
    echo '</tr>';
    echo '</thead>';
    return $cabecalho[0];
}

function monta_corpo(&$tabela) {
    echo "<tbody>";
    $saida = (get_linhas($tabela)) ? 1 : 0;
    echo "</tbody>";
    return $saida;
}

function monta_tabela($tabela) {
    echo '<table class="table table-striped table-hover">';
    $count_cabecalho = monta_cabecalho($tabela);
    if (empty(monta_corpo($tabela))) {
        echo '<tr><td style="font-weight:bold;" colspan="'.$count_cabecalho.'"> Nenhum registro encontrado </td><tr>';
    }
    echo '</table>';
}

function adiciona_campo($array) {
    $chaves = array_keys($array);
    $colunas = implode("`,`", $chaves);
    $colunas = "`".$colunas."`";
    return $colunas;
}

function adiciona_valores($array) {
    $valores = array_walk($array, function ($elemento) {
        $elemento = mysqli_real_escape_string(get_conexao(), $elemento);
    });
    $valores = implode("','",$array);
    $valores = "'".$valores."'";
    return utf8_decode($valores);
}

function db_insert($tabela="",$array=array(),$codigo=false) {
    $saida = 0;

    $colunas = adiciona_campo($array);
    $valores = adiciona_valores($array);
    $comando = "Insert into $tabela ($colunas) values ($valores)";
    $resultado = mysqli_query(get_conexao(), $comando);
    if (!empty($resultado)) {
        $saida = 1;
    }

    if (!empty($codigo)) {
        return mysqli_insert_id(get_conexao());
    }
    return $saida;
}