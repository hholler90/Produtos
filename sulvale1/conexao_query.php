<?php

$host = "localhost";
$user = "root";
$senha = "root";
$banco = "sulvale1";
$con_sgi = mysql_connect($host,$user,$senha) or die ("Erro: Falha ao conectar ao banco de dados");
$selsgi = mysql_select_db($banco,$con_sgi);


//@include('conexao.php')

//=====================
//Clientes
//=====================
//  $sql001 ="";
//  $sql001 ="insert into usuario(nome,email,senha) value('carlos','carlos@gmail.com','teste');";
//  $res001 = mysql_query($sql001);
//  echo "\nsql:".$sql001;
//  echo "\nerror:".mysql_error();


// $sql002 ="";
// $sql002 ="select id, nome,quantidade,preco from produto; ";
// $res002 = mysql_query($sql002);
// echo "\nsql:".$sql002;
// echo "\nerror:".mysql_error();

// if(mysql_num_rows($res002)>0){
//   $clientes = [];
//   while($linha=mysql_fetch_array($res002)){
//     $id         = $linha[0];
//     $nome       = trim($linha[1]);
//     $quantidade = $linha[2];
//     $preco      = $linha[3];
//     echo "$id $nome $quantidade $preco \n";

//   }
// }

// if(mysql_num_rows($res001)>0){
//   $clientes = [];
//   while($linha=mysql_fetch_array($res001)){
//     $id         = $linha[0];
//     $nome       = trim($linha[1]);
//     $email = $linha[2];
//     $senha      = $linha[3];
//     echo "$id $nome $email $senha \n";

//   }
// }  



?>
