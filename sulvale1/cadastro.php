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
    <form class="mt-5">
        <h2 class="text-center">Cadastre-se</h2>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputEmail1">Endereço de email</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu email">         
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputEmail1">Nome de Usuario</label>
          <input type="text" class="form-control" id="exampleInputUsuario" aria-describedby="emailHelp" placeholder="Seu Usuario">         
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
          <label for="exampleInputPassword1">Senha</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha">
        </div>
        <div class="form-group col-md-5 mx-auto m-1">
            <label for="exampleInputPassword1">Confimre sua senha</label>
            <input type="password" class="form-control " id="exampleInputPassword1" placeholder="Senha">
          </div>
        <div class="form-group col-md-5 mx-auto text-center m-1">
          <button type="submit" class="btn btn-primary " onclick="return validar()">Cadastrar-se</button>
          <div class="g-recaptcha p-3 " data-sitekey="6Lfbb48oAAAAALjbD8IZY5p89wcZdxeo7cINIZ6V"></div>

        </div>
        <script type="text/javascript">
          function validar(){
            if(grecapcha.getResponse()==""){
              alert("Voce deve marcar a validacao")
              return false;
            }
          }
        </script>
        
      </form>    
</body>
</html>


