<?php
@include('conexao_query.php');

session_start();
session_unset();
session_destroy();
header("location: index.php");
?>