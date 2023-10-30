<?php
@include('conexao_query.php');
session_start();


$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$result_produto="delete from produto where id='$id'";
$result_query=mysql_query($result_produto);

    if ($result_query) {
        echo "Registro excluído com sucesso";
    } else {
        echo "Erro ao excluir o registro: " . mysql_error();
    }
    sleep(1);
    header("location:tabela.php");
?>