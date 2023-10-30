<?php
    
    @include('conexao_query.php');
    session_start();


    if(isset($_SESSION["usuario"])){
      header("Location: /sulvale1/tabela.php");
      exit;
    }

    if (isset($_POST["email"])) {
      $email = trim($_POST["email"]);
      $senha = $_POST["senha"];

      $query="select * from usuario where email='$email' and  senha='$senha'";
      $result=mysql_query($query);

      if (mysql_num_rows($result) == 1) {


        while($linha=mysql_fetch_array($result)){

              $usuario=[
                'id' => $linha[0],
                'nome' => trim($linha[1]),
                'email' =>trim($linha[2]),
                'senha' => $linha[3]
              ];             
        }
        $_SESSION["usuario"] =$usuario;

        header("Location: /sulvale1/tabela.php");
        exit;
      }
      else{
        echo"Erro: Email ou senha invalidos.";
      }     
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">   
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

    <form class="mt-5" action="/sulvale1/index.php" method="post">
        <h2 class="text-center">Faça seu Login</h2>
        <div class="form-group col-md-5 mx-auto">
          <label for="exampleInputEmail1">Endereço de email</label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu email">
          <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email com ninguém.</small>
        </div>
        <div class="form-group col-md-5 mx-auto">
          <label for="exampleInputPassword1">Senha</label>
          <input name="senha" type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
        </div>
        <div class="form-group form-check col-md-5 mx-auto">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Lembrar e-mail</label>
          
        </div>

        <div class="form-group col-md-5 mx-auto text-center">
          <input type="submit" class="btn btn-primary  " value="Entrar" >
          <button type="button" class="btn btn-primary " onclick="abrirCadastro()">Cadastrar-se</button> 
          <!-- <div class="g-recaptcha p-3 " data-sitekey="6Lfbb48oAAAAALjbD8IZY5p89wcZdxeo7cINIZ6V"></div>  -->
      </form> 
        </div>
        <script>
          // function validar(){
          //   if(grecapcha.getResponse()==""){
          //     alert("Voce deve marcar a validacao")
          //     return false;
          //   }
          // }
          function abrirTabela() {
            window.location.href = "tabela.php";
          }

          function abrirCadastro() {
            window.location.href = "cadastro.php";
          }
        </script> 
        
         
</body>
</html>


