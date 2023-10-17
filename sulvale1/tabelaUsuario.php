<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="style.css">
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet" >
    <script src="js/bootstrap.bundle.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Home</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                  <li class="nav-item active">
                      <a type="button" class="nav-link" onclick="abrirLogin()">Página de Login</a>
                  </li>                 
                  <li class="nav-item">
                    <a type="button" class="nav-link" onclick="abrirTabela()" >Produtos</a>
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
                <th class="th">Opções</th>
            </thead>
            <tbody id="tbody">
                <!-- Aqui serão listados os usuários cadastrados -->
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
            <div class="modal-body">
                <div class="row label">
                    <label>Nome de Usuário</label>
                    <input class="inputTamanho" type="text" id="usuario" placeholder="Nome de Usuário" required>
                </div>
                <div class="row label">
                    <label>Email</label>
                    <input class="inputTamanho" type="email" id="email" placeholder="Email" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" id="btnCancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="usuario.limpar()" type="reset" id="btnLimpar" class="btn btn-primary">Limpar</button>
                <button onclick="usuario.salvar()" type="button" id="btnAdicionar" class="btn btn-primary">Salvar</button>
            </div>
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
   usuario.nomeUsuario.toLowerCase()===(termoPesquisa)
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

       td_Id.classList.add('listaScript');
       td_NomeUsuario.classList.add('listaScript');
       td_Email.classList.add('listaScript');
       td_Opcoes.classList.add('listaScript');

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
       let td_Opcoes =tr.insertCell();

       td_Id.classList.add('listaScript');
       td_NomeUsuario.classList.add('listaScript');
       td_Email.classList.add('listaScript');
       td_Opcoes.classList.add('listaScript');

       td_Id.innerText=usuarios[i].id;
       td_NomeUsuario.innerText=usuarios[i].nomeUsuario;
       td_Email.innerText=usuarios[i].email;
       
               
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
     this.editId=dados.id;
     //console.log(dados);
         
     document.getElementById('usuario').value=dados.nomeUsuario;
     document.getElementById('email').value=dados.email;
     
     }


   atualizar(id,usuario){ 
       for (let i=0; i<this.arrayUsuario.length;i ++){
           if(this.arrayUsuario[i].id==id){
             this.arrayUsuario[i].nomeUsuario=usuario.nomeUsuario;
             this.arrayUsuario[i].email=usuario.email;
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
     usuario.nomeUsuario = document.getElementById("usuario").value.trim();
     usuario.email = document.getElementById("email").value.trim();
     return usuario;
    }
   //Funcion que valida os campos e chama um alert se os dados nao foram preenchidos corretamente
   validaCampos(usuario){
      let msg= "";

      if (usuario.nomeUsuario == ''){
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

       for(let i= 0; i < this.arrayUsuario.length; i++){
         if(this.arrayUsuario[i].id == id){
           this.arrayUsuario.splice(i,1);
           tbody.deleteRow(i);
                }    
            }     
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

// produto.listaTabela();

</script>
</body>
</html>
