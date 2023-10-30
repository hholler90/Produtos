
  <?php
    @include('conexao_query.php');
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
        $usuario =trim($_POST["usuario"]);
        $senha = $_POST["senha"];
        $confirmaSsenha = $_POST["confirma_senha"];

      $query = "select nome,email from usuario where email='$email' OR nome='$usuario'";  
      if(!empty($id)){
          $query_email.=" and id!= $id";
        }
        $result=mysql_query($query);

        if( (mysql_num_rows($result) > 0) ){
          echo "<script>alert('Este email ou usuario já foram cadastrados!');</script>";
        }
      else{   
          $sql003="insert into usuario(nome,email,senha) values('$usuario','$email','$senha');";
        }
        $sql003 = mysql_query($sql003);
        echo "\nsql:".$sql003;
        echo "\nerror:".mysql_error();
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
    <form class="mt-5" action="/sulvale1/cadastro.php" method="post">
    <input type="hidden" id="id" name="id" value="">
        <h2 class="text-center">Cadastre-se</h2>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputEmail1">Endereço de email</label>
          <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu email" required>         
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputEmail1">Nome de Usuario</label>
          <input name="usuario" type="text" class="form-control" id="usuario" aria-describedby="emailHelp" placeholder="Seu Usuario" required>         
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputPassword1">Senha</label>
          <input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" required>
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
            <label for="exampleInputPassword1">Confimre sua senha</label>
            <input name="confirma_senha" type="password" class="form-control " id="confirma_senha" placeholder="Senha" required>
          </div>
        <div class="form-group col-md-5 mx-auto text-center m-1">
          <input type="submit" class="btn btn-primary " value="Cadastrar-se">
          <a type="button" href='index.php' class="btn btn-primary m-3">Voltar ao login</a>
          <!-- <div class="g-recaptcha p-3 " data-sitekey="6Lfbb48oAAAAALjbD8IZY5p89wcZdxeo7cINIZ6V"></div> -->

        </div>
        <!-- <script type="text/javascript">
          function validar(){
            if(grecapcha.getResponse()==""){
              alert("Voce deve marcar a validacao")
              return false;
            }
          }
        </script> -->
        
      </form>  
      <script>function abrirLogin() {
   window.location.href = "index.php";
 }</script>  
</body>
</html>


