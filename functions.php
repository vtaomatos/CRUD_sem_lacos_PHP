<?php

$conexao = mysqli_connect('localhost','root','', 'teste_backsite');


function get_conexao() {
    global $conexao;
    return $conexao;
}

function db_select($comando, $array=array(), $cabecalho=false) {

    $comando = !empty($array) ? sf($comando, $array) : $comando;
    
    $resultado = mysqli_query(get_conexao(), $comando);
    $saida = mysqli_fetch_all($resultado);
    $lista = array();
    $campos = campos($resultado);

    array_walk($saida, function($elementoPai, $chavePai) use (&$lista, $campos) {
        array_walk($elementoPai, function($valor, $chave) use (&$lista, $campos, $chavePai){
            $lista[$chavePai][$campos[$chave]] = $valor;
        });
    });

    $saida = $lista;

    if (!empty($cabecalho)) {
        array_unshift($saida,$campos);
    }

    array_walk_recursive($saida, function(&$item){
        $item = utf8_encode($item);
    });

    return $saida;
}

function db_select_one($comando, $array=array(), $cabecalho=false) {
    $retorno = db_select($comando, $array, $cabecalho);
    if (count($retorno) == 1) {
        $retorno = array_shift($retorno);
    } else {
        $retorno = false;
    }
    return $retorno;
}

function db_update($nome_tabela, $campos, $where) {
    if (empty($campos)) {
        exit("PASSAR CAMPOS");
    }
    if (empty($nome_tabela)) {
        exit("PASSAR NOME DA TABELA");
    }
    if (empty($where)) {
        exit("PASSAR WHERE");
    }
    $keys = array_keys($campos);
    $set = array();
    array_walk($keys, function($valor) use ($campos, &$set){
        $set[] = $valor . ' = "'. addslashes($campos[$valor]).'"';
    });
    $campos = join(", ", $set);

    $keys = array_keys($where);
    $condicao = array();
    array_walk($keys, function($valor) use ($where, &$condicao){
        $condicao[] = $valor . ' = "'. addslashes($where[$valor]).'"';
    });
    $where = join(" AND ", $condicao);

    $sql = '
        UPDATE
            :nome_tabela
        SET
            :campos
        WHERE
            :where
    ';
    $comando = sf($sql, array(
        'nome_tabela' => $nome_tabela,
        'campos' => $campos,
        'where' => $where
    ));

    mysqli_query(get_conexao(), utf8_decode($comando));
}

function campos($resultado){
    $saida = mysqli_fetch_fields($resultado);
    array_walk($saida, function (&$campo) {
        $campo = $campo->name;
    });
    return $saida;
}

function get_colunas($colunas, $codigo="") {
    array_map(function ($coluna) {
        echo "<td>";
        echo $coluna;
        echo "</td>";
    }, $colunas);
    echo "<td>";
    echo '<a style="color:inherit" class="btn btn-detalhes" href="detalhes.php?codigo='.$codigo.'"><i class="material-icons">forward</i></a>';
    echo "</td>";
}

function get_linhas($tabela, $configs, $chaves=array()){
    $saida = array_map(function ($linha) use ($configs, $chaves) {
        $tr = '<tr ';
        $tr .= (!empty($configs['title']) ? 'title = "' . sf($configs['title'], $linha) . '">' : '>') ;
        echo $tr;
        get_colunas($linha, array_shift($chaves));
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

function monta_corpo(&$tabela, $configs, $chaves=array()) {
    echo "<tbody>";
    $saida = (get_linhas($tabela, $configs, $chaves)) ? 1 : 0;
    echo "</tbody>";
    return $saida;
}

function monta_tabela($campos,$tabela, $configs=array()) {
    $keys_campos = array_keys($campos);
    $chaves = array();
    array_walk($tabela, function($valorPai, $chavePai) use ($keys_campos, &$tabela, &$chaves, $configs){
        array_walk($valorPai, function($valor, $chave) use ($keys_campos, &$tabela, $chavePai, &$chaves, $configs){
            if($chave == $configs['chave']){
                $chaves[] = $valor;
            }
            if (!in_array($chave, $keys_campos)) {
                unset($tabela[$chavePai][$chave]);
            }
        });
    });
    array_unshift($tabela, $campos);
    echo '<table class="table table-striped table-hover">';
    $count_cabecalho = monta_cabecalho($tabela);
    if (empty(monta_corpo($tabela, $configs, $chaves))) {
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

function echo_r($conteudo) {
    print_r("<pre>");
    print_r($conteudo);
    print_r("</pre>");
}

function sf($string, $array) {
    array_walk($array, function ($valor, $chave) use (&$string){
        $string = str_replace(":".$chave, $valor, $string);
    });
    return $string;
}