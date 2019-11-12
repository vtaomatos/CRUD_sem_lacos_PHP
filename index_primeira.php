<?php


	
$consulta = "SELECT * FROM noticia";
echo "<pre>";
$itens = array();
$noticias = db_select($consulta);


function db_select($comando) {
    $contador = 0;
	$conexao = mysqli_connect('localhost','root','', 'teste_backsite');
    $resultado = mysqli_query($conexao, $comando);
    $retorno = percorre($resultado, $contador);
    global $itens;
    return $itens;
}

function percorre($lista, $contador = 0) {
    $fez = 0;
    if ($contador <= mysqli_num_rows($lista)) {
        $fez = 1;
        mysqli_field_seek($lista, $contador);
        global $itens;
        $resposta = mysqli_fetch_assoc($lista);
        if ($resposta != null) {
            $itens[] = $resposta;
        }
        $contador++;
        percorre($lista, $contador);
    }
    return $fez;
}

function linhas($tabela, $indice = 0) {
    if ($indice < count($tabela)) {
        echo "<tr>";
        echo "<td>";
        echo $tabela[$indice]['id'];
        echo "</td>";
        echo "<td>";
        echo $tabela[$indice]['titulo'];
        echo "</td>";
        echo "<td>";
        echo $tabela[$indice]['descricao'];
        echo "</td>";
        echo "<td>";
        echo $tabela[$indice]['slug'];
        echo "</td>";
        echo "</tr>";
        $indice++;
        linhas($tabela, $indice);
    } else {
        echo "<tr>";
        echo "</tr>";
    }
}
?>

<table>
    <thead>
        <tr>
            <td>
                Id
            </td>
            <td>
                Título
            </td>
            <td>
                Descrição
            </td>
            <td>
                Slug
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
            linhas($noticias);
        ?>
    </tbody>
</table>

<?php
// print_r(db_select($consulta));