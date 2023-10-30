<?php

session_start();
@include('conexao_query.php');
$result_produto="select from produto where id='5' ";
$result_query=mysql_query($result_produto);
$row_produto=mysql_fetch_assoc($result_query);
?>