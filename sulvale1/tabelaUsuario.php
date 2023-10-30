<?php
    @include('conexao_query.php');
    session_start();
    if(!isset($_SESSION["usuario"])){
      header("Location: /sulvale1/index.php");
      exit;
    }

  if(isset($_POST["usuario"])){
    $usuario=$_POST["usuario"];
    $email=$_POST["email"];
    $senha=$_POST["senha"];
    $id=$_POST["id"];
    $perfil_id = $_POST["perfil_id"];

      $query = "select nome,email from usuario where email='$email' OR nome='$usuario'";  
     if(!empty($id)){
         $query_email.=" and id!= $id";
       }
       $result=mysql_query($query);

       if( (mysql_num_rows($result) > 0) ){
         echo "<script>alert('Este email ou usuario já foram cadastrados!');</script>";
       }
     else{
      if(!empty($id)){
            $sql003="update usuario set nome='$usuario',email='$email', senha='$senha',perfil_id=$perfil_id where id=$id;";
        }
      else{
            $sql003="insert into usuario(nome,email,senha,perfil_id) values('$usuario','$email','$senha',$perfil_id);";
        }
      $sql003 = mysql_query($sql003);
      echo "\nsql:".$sql003;
      echo "\nerror:".mysql_error();
    }    
  }
    
        $sql002 ="";
        $sql002 = "SELECT u.id, u.nome, u.email, p.perfil_nome FROM usuario u INNER JOIN perfis p ON u.perfil_id = p.id";
        $res002 = mysql_query($sql002);

        $sql002 = mysql_query($sql002);
        echo "\nsql:".$sql002;
        echo "\nerror:".mysql_error();

        $usuarios = [];
        
    if(mysql_num_rows($res002)>0){       
       while($linha=mysql_fetch_array($res002)){
        $usuarios[] = (object)[
          'id' =>trim ($linha[0]),
          'nome' =>trim($linha[1]),
          'email' =>trim ($linha[2]),
          'perfil_nome' =>trim ($linha[3])
        ];
        
       }
      }
  ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Usuários</title>
    <link rel="stylesheet" href="style.css">
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet" >
    <script src="js/bootstrap.bundle.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

</head>
<body>

  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?php
      if(isset($_SESSION["usuario"]["nome"])){
        $nome = $_SESSION["usuario"]["nome"];
        echo "Olá $nome";
    }
    ?>     
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">              
                  <li class="nav-item">
                    <a type="button" class="nav-link" onclick="abrirTabela()" >Produtos</a>
                </li> 
                <li class="nav-item">
                      <a type="button" class="nav-link" onclick="abrirTabelaPerfil()" >Perfis</a>
                  </li>               
              </ul>
              <ul class="navbar-nav ml-10" >
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="perfilDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Meu Perfil
                </a>
                <div class="dropdown-menu" aria-labelledby="perfilDropdown">
                    <a class="dropdown-item" href="#">Ver Perfil</a>
                    <a class="dropdown-item" href="#">Configuraçãoes</a>
                    <div class="dropdown-divider"></div>
                    <?php echo "<a href='logout.php' class='nav-link' onclick='return confirm(\"Deseja sair da página\")'>Sair</a>"?>
                </div>
            </li>
        </ul>
          </div>    
    </nav>
    <h2>Tabela de Usuários</h2>
    <!-- Barra de pesquisa e botão que chama o modal de cadastro -->
    <div class="barraPesquisa">
        <input id="searchbar" type="input" class="form-control w-25 m-1" placeholder="Buscar" aria-label="Search" aria-describedby="search-addon"/>
        <button type="button" class="btn btn-outline-primary m-1" onclick="usuario.pesquisa()">Buscar</button>
        <button id="botaoModal" type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Novo Usuário</button>
    </div>
    <!-- Tabela de Usuários -->
    <div>
        <table class="table table-striped">
            <thead>
                <th class="th">ID</th>
                <th class="th">Nome de Usuário</th>
                <th class="th">Email</th>
                <th class="th">Tipo de Usuário</th>
                <th class="th">Opções</th>
            </thead>
            <tbody id="tbody">
            <?php 
              if (count($usuarios)==0){
                echo "<tr><td>sem usuarios</td></tr>";

              }
              else{
                foreach($usuarios as $usuario){
                  echo "<tr>
                  <td class='listaScript'>".$usuario->id."</td>
                  <td class='listaScript'>".$usuario->nome."</td>
                  <td class='listaScript'>".$usuario->email."</td>
                  <td class='listaScript'>".$usuario->perfil_nome."</td>
                  <td><a class='buttonEditar'onclick='usuario.editar(\"" . str_replace('"','\"', json_encode($usuario)) . "\")'>Editar</a>
                      <a href='excluirUsuario.php?id=".$usuario->id."' class='buttonExcluir' onclick='return confirm(\"Deseja excluir o produto de ".$usuario->nome."\")'>Excluir </a>
                  </td>
                  </tr>";                
                }
              }
            
              ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal de Cadastro de Usuários -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/sulvale1/tabelaUsuario.php" method="post">
            <div class="modal-body">
            <input type="hidden" id="id" name="id" value="">
                <div class="row label">
                    <label class="labelNome">Nome de Usuário</label>
                    <input style="width: 466px;" class="inputTamanho" type="text" id="usuario" name="usuario" placeholder="Nome de Usuário" required>
                </div>
                <div class="row label">
                    <label class="labelNome">Email</label>
                    <input style="width: 466px;" class="inputTamanho" type="email" name="email" id="email" placeholder="Email" required>
                </div>               
                <div class="row label">
                    <label class="labelNome">Senha</label>
                    <input style="width: 466px;" class="inputTamanho" type="password" name="senha" id="senha" placeholder="Senha" required>
                </div> 
                <div class="row label">
                <label class="labelNome">Tipo de Usuário</label>
                <select style="width: 466px;" class="inputTamanho" name="perfil_id" id="tipo" >
                    <option value="1">Padrão</option>
                    <option value="2">Admin</option>
                </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" id="btnCancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="reset" id="btnLimpar" class="btn btn-primary">Limpar</button>
                <input type="submit" class="btn btn-primary" value="Salvar" id="btnAdicionar"> 
            </div>
            </form>
        </div>
    </div>
</div>
<script>
  
class Usuario{

   constructor(){
     this.id= 1;
     this.arrayUsuario=[];
     this.editId=null;
   }
    
 pesquisa() {
   const termoPesquisa = document.getElementById('searchbar').value.toLowerCase().trim();

     if(termoPesquisa===""){
           this.listaTabela(this.arrayUsuario);
           return true;
         }
   const resultados = usuario.arrayUsuario.filter((usuario) =>
   usuario.nome.toLowerCase()===(termoPesquisa)
   );
   if(resultados===undefined || resultados.length==0){
       alert("Nenhum usuario cadastrado com esse nome!");
       return true;
     }
    
     this.listaTabela(resultados);
   //console.log(termoPesquisa);
   }
      
   // Funcion que envia informacoes cadastradas para a tabela
   salvar(){
       let usuario=this.lerDados();
       
        if(this.validaCampos(usuario)){
         if (this.editId==null){
           this.adicionar(usuario);
         }
         else{
           this.atualizar(this.editId,usuario);
         }
          
        }
       this.listaTabela(this.arrayUsuario);
       this.limpar();
   }
   // Funcion que cria as array e linhas da tabela 
   listaTabela(usuarios){
     let tbody=document.getElementById('tbody');
     tbody.innerText ='';

     if(usuarios===undefined || usuarios.length==0){
       
       let tr=tbody.insertRow();

       let td_Id =tr.insertCell();
       let td_NomeUsuario =tr.insertCell();
       let td_Email =tr.insertCell();
       let td_Opcoes =tr.insertCell();
       let td_perfil_id =tr.insertCell();

       td_Id.classList.add('listaScript');
       td_NomeUsuario.classList.add('listaScript');
       td_Email.classList.add('listaScript');
       td_Opcoes.classList.add('listaScript');
       td_perfil_id.classList.add('listaScript');

       td_Id.innerText=("null");
       td_NomeUsuario.innerText=("Nenhum Usuario");
       td_Email.innerText=("Nenhum email");
       
     }
     console.log(usuarios)
     for(let i= 0; i < usuarios.length; i++){
       let tr=tbody.insertRow();

       let td_Id =tr.insertCell();
       let td_NomeUsuario =tr.insertCell();
       let td_Email =tr.insertCell();
       let td_perfil_id =tr.insertCell();
       let td_Opcoes =tr.insertCell();
       
       td_Id.classList.add('listaScript');
       td_NomeUsuario.classList.add('listaScript');
       td_Email.classList.add('listaScript');
       td_perfil_id.classList.add('listaScript');
       td_Opcoes.classList.add('listaScript');
       
       td_Id.innerText=usuarios[i].id;
       td_NomeUsuario.innerText=usuarios[i].nome;
       td_Email.innerText=usuarios[i].email;
       td_perfil_id.innerText=usuarios[i].perfil_nome;
       
               
       var buttonEditar = document.createElement('button');
       buttonEditar.setAttribute("data-bs-toggle","modal");
       buttonEditar.setAttribute("data-bs-target","#exampleModal");
       buttonEditar.setAttribute("onclick","usuario.editar("+JSON.stringify(usuarios[i])+")");
       td_Opcoes.appendChild(buttonEditar);
       buttonEditar.appendChild(document.createTextNode('Editar'));
       buttonEditar.classList.add('buttonEditar');
       
       var buttonExcluir = document.createElement('button');
       buttonExcluir.setAttribute("onclick","usuario.excluir("+usuarios[i].id+")");
       buttonExcluir.appendChild(document.createTextNode('Excluir'));
       td_Opcoes.appendChild(buttonExcluir);
       buttonExcluir.classList.add('buttonExcluir');
       
     }
   }


   editar(dados){
    dados=JSON.parse(dados)
     this.editId=dados.id;
     //console.log(dados);
     const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));myModal.show();


      document.getElementById('id').value=dados.id;
      document.getElementById('usuario').value=dados.nome;
      document.getElementById('email').value=dados.email;
      document.getElementById('senha').value=dados.senha;
      

     }


   atualizar(id,usuario){ 
       for (let i=0; i<this.arrayUsuario.length;i ++){
           if(this.arrayUsuario[i].id==id){
             this.arrayUsuario[i].nome=usuario.nome;
             this.arrayUsuario[i].email=usuario.email;
             this.arrayUsuario[i].perfil_id=usuario.perfil_id;
           }
       }
     }
   //Funcion que adiciona os dados na array
   adicionar(usuario){
     this.arrayUsuario.push(usuario);
     this.id++;
    }
   //Funcion que le os dados digitados na modal de cadastro
   lerDados(){
     let usuario = {}
     
     usuario.id=this.id;
     usuario.nome = document.getElementById("usuario").value.trim();
     usuario.email = document.getElementById("email").value.trim();
     return usuario;
    }
   //Funcion que valida os campos e chama um alert se os dados nao foram preenchidos corretamente
   validaCampos(usuario){
      let msg= "";

      if (usuario.nome == ''){
        msg+="- Informe o nome do usuario\n"
      }
      if (usuario.email == ''){
        msg+="- Informe o Email\n"
      }
      if (msg !=""){
        alert(msg);
        return false
      }

      return true;
    }
   //Funcion que limpa os campos da modal de cadastro
   limpar(){
     document.getElementById("email").value='';
     document.getElementById("usuario").value='';
    }

     excluir(id){
      if(confirm('Deseja excluir o usuario do ID ' +id)){

        let tbody=document.getElementById('tbody');

    //    for(let i= 0; i < this.arrayUsuario.length; i++){
    //      if(this.arrayUsuario[i].id == id){
    //        this.arrayUsuario.splice(i,1);
    //        tbody.deleteRow(i);
    //             }    
    //         }     
         }
     
     }
}
var usuario = new Usuario();

 function abrirCadastro() {
   window.location.href = "cadastro.php";
 }
 function abrirLogin() {
   window.location.href = "index.php";
 }
 function abrirTabela() {
            window.location.href = "tabela.php";
          }
function abrirTabelaPerfil() {
            window.location.href = "perfil.php";
          }

// produto.listaTabela();

</script>
</body>
</html>
<?php  echo "<script> usuario.arrayUsuario = JSON.parse('" . json_encode($usuarios) . "')</script>" ?>
