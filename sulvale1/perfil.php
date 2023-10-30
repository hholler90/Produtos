<?php
    @include('conexao_query.php');
    session_start();
    if(!isset($_SESSION["usuario"])){
      header("Location: /sulvale1/index.php");
      exit;
    }

  if(isset($_POST["perfil_nome"])){
    $perfil_nome=$_POST["perfil_nome"];
    $id=$_POST["id"];

    if(!empty($id)){
        $sql003="update usuario set perfil_nome='$perfil_nome' where id=$id;";
    }
    else{
        $sql003="insert into perfis(perfil_nome) values('$perfil_nome');";
    }
      $sql003 = mysql_query($sql003);
      echo "\nsql:".$sql003;
      echo "\nerror:".mysql_error();
  }      
        $sql002 ="";
        $sql002 ="select id, perfil_nome from perfis; ";
        $res002 = mysql_query($sql002);
        
        $perfis = [];
        
    if(mysql_num_rows($res002)>0){       
       while($linha=mysql_fetch_array($res002)){
        $perfis[] = (object)[
          'id' =>trim ($linha[0]),
          'perfil_nome' =>trim($linha[1]),
        ];

       }
      }
  ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Perfis</title>
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
                    <a type="button" class="nav-link" onclick="abrirTabelaUsuario()" >Usuários</a>
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
    <h2>Tabela de Perfis</h2>
    <!-- Barra de pesquisa e botão que chama o modal de cadastro -->
    <div class="barraPesquisa">
        <input id="searchbar" type="input" class="form-control w-25 m-1" placeholder="Buscar" aria-label="Search" aria-describedby="search-addon"/>
        <button type="button" class="btn btn-outline-primary m-1" onclick="perfil.pesquisa()">Buscar</button>
        <button id="botaoModal" type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Novo Perfil</button>
    </div>
    <!-- Tabela de Usuários -->
    <div>
        <table class="table table-striped">
            <thead>
                <th class="th">ID</th>
                <th class="th">Nome de Perfil</th>
                <th class="th">Opções</th>
            </thead>
            <tbody id="tbody">
            <?php 
              if (count($perfis)==0){
                echo "<tr><td>sem perfis</td></tr>";

              }
              else{
                foreach($perfis as $perfil){
                  echo "<tr>
                  <td class='listaScript'>".$perfil->id."</td>
                  <td class='listaScript'>".$perfil->perfil_nome."</td>
                  <td><a class='buttonEditar'onclick='perfil.editar(\"" . str_replace('"','\"', json_encode($perfil)) . "\")'>Editar</a>
                      <a href='excluirPerfil.php?id=".$perfil->id."' class='buttonExcluir' onclick='return confirm(\"Deseja excluir o produto de ".$perfil->nome."\")'>Excluir </a>
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/sulvale1/perfil.php" method="post">
            <div class="modal-body">
            <input type="hidden" id="id" name="id" value="">
                <div class="row label">
                <label class="labelNome">Tipo de Usuário</label>
                <select style="width: 466px;" class="inputTamanho" name="perfil_nome" id="perfil_nome" >
                    <option value="Padrão">Padrão</option>
                    <option value="Admin">Admin</option>
                </select>
                </div>                    
            <div class="modal-footer">
                <button type="reset" id="btnCancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="perfil.limpar()" type="reset" id="btnLimpar" class="btn btn-primary">Limpar</button>
                <input type="submit" class="btn btn-primary" value="Salvar" id="btnAdicionar"> 
            </div>
            </form>
        </div>
    </div>
</div>
<script>
  
class Perfil{

   constructor(){
     this.id= 1;
     this.arrayPerfil=[];
     this.editId=null;
   }
    
 pesquisa() {
   const termoPesquisa = document.getElementById('searchbar').value.toLowerCase().trim();

     if(termoPesquisa===""){
           this.listaTabela(this.arrayPerfil);
           return true;
         }
   const resultados = perfil.arrayPerfil.filter((perfil) =>
   perfil.perfil_nome.toLowerCase()===(termoPesquisa)
   );
   if(resultados===undefined || resultados.length==0){
       alert("Nenhum perfil cadastrado com esse nome!");
       return true;
     }
    
     this.listaTabela(resultados);
   //console.log(termoPesquisa);
   }
      
   // Funcion que envia informacoes cadastradas para a tabela
   salvar(){
       let perfil=this.lerDados();
       
        if(this.validaCampos(perfil)){
         if (this.editId==null){
           this.adicionar(perfil);
         }
         else{
           this.atualizar(this.editId,perfil);
         }
          
        }
       this.listaTabela(this.arrayPerfil);
       this.limpar();
   }
   // Funcion que cria as array e linhas da tabela 
   listaTabela(perfis){
     let tbody=document.getElementById('tbody');
     tbody.innerText ='';

     if(perfis===undefined || perfis.length==0){
       
       let tr=tbody.insertRow();

       let td_Id =tr.insertCell();
       let td_NomePerfil =tr.insertCell();
       
       

       td_Id.classList.add('listaScript');
       td_NomePerfil.classList.add('listaScript');
       td_Tipo.classList.add('listaScript');
       td_Opcoes.classList.add('listaScript');

       td_Id.innerText=("null");
       td_NomePerfil.innerText=("Nenhum Perfil");
       
       
     }
     console.log(perfis)
     for(let i= 0; i < perfis.length; i++){
       let tr=tbody.insertRow();

       let td_Id =tr.insertCell();
       let td_NomePerfil =tr.insertCell();
       
       let td_Opcoes =tr.insertCell();

       td_Id.classList.add('listaScript');
       td_NomePerfil.classList.add('listaScript');
       
       td_Opcoes.classList.add('listaScript');

       td_Id.innerText=perfis[i].id;
       td_NomePerfil.innerText=perfis[i].perfil_nome;
       
       
               
       var buttonEditar = document.createElement('button');
       buttonEditar.setAttribute("data-bs-toggle","modal");
       buttonEditar.setAttribute("data-bs-target","#exampleModal");
       buttonEditar.setAttribute("onclick","usuario.editar("+JSON.stringify(perfis[i])+")");
       td_Opcoes.appendChild(buttonEditar);
       buttonEditar.appendChild(document.createTextNode('Editar'));
       buttonEditar.classList.add('buttonEditar');
       
       var buttonExcluir = document.createElement('button');
       buttonExcluir.setAttribute("onclick","usuario.excluir("+perfis[i].id+")");
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
      document.getElementById('perfil_nome').value=dados.perfil_nome;
      
     }
   atualizar(id,perfil){ 
       for (let i=0; i<this.arrayPerfil.length;i ++){
           if(this.arrayPerfil[i].id==id){
             this.arrayPerfil[i].perfil_nome=perfil.perfil_nome;
           }
       }
     }
   //Funcion que adiciona os dados na array
   adicionar(perfil){
     this.arrayPerfil.push(perfil);
     this.id++;
    }
   //Funcion que le os dados digitados na modal de cadastro
   lerDados(){
     let perfil = {}
     
     perfil.id=this.id;
     perfil.perfil_nome = document.getElementById("perfil_nome").value.trim();
     return perfil;
    }
   //Funcion que valida os campos e chama um alert se os dados nao foram preenchidos corretamente
   validaCampos(perfil){
      let msg= "";

      if (usuario.perfil_nome == ''){
        msg+="- Informe o nome do perfil\n"
      }
      if (usuario.tipo == ''){
        msg+="- Informe o tipo\n"
      }
      if (msg !=""){
        alert(msg);
        return false
      }

      return true;
    }
   //Funcion que limpa os campos da modal de cadastro
   limpar(){
     //document.getElementById("tipo").value='';
     document.getElementById("perfil_id").value='';
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
var perfil = new Perfil();

 function abrirCadastro() {
   window.location.href = "cadastro.php";
 }
 function abrirLogin() {
   window.location.href = "index.php";
 }
 function abrirTabela() {
            window.location.href = "tabela.php";
          }
  function abrirTabelaUsuario() {
    window.location.href = "tabelaUsuario.php";
  }
// produto.listaTabela();

</script>
</body>
</html>
<?php  echo "<script> perfil.arrayPerfil = JSON.parse('" . json_encode($perfis) . "')</script>" ?>
