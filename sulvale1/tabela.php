
<?php
    @include('conexao_query.php');
    
    if(isset($_POST["produto1"])){

    $produto=$_POST["produto1"];
    $preco=$_POST["preco1"];
    $quantidade=$_POST["quantidade1"];
    $id=$_POST["id"];
    if(!empty($id)){
      $sql003="insert into produto(nome,preco,quantidade) values('$produto',$preco,$quantidade);";
    }
    else{
      $sql003="insert into produto(nome,preco,quantidade) values('$produto',$preco,$quantidade);";
    }
    $sql003 = mysql_query($sql003);
    echo "\nsql:".$sql003;
    echo "\nerror:".mysql_error();

     
       }
    
        $sql002 ="";
        $sql002 ="select id, nome,quantidade,preco from produto; ";
        $res002 = mysql_query($sql002);
        $produtos = [];
        
    if(mysql_num_rows($res002)>0){       
       while($linha=mysql_fetch_array($res002)){
        $produtos[] = (object)[
          'id' => $linha[0],
          'nome' =>trim($linha[1]),
          'preco' => $linha[2],
          'quantidade' => $linha[3]
        ];

       }
      }
  ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="style.css">
    <link href="css/bootstrap-reboot.min.css" rel="stylesheet" >
    <script src="js/bootstrap.bundle.js"></script>
</head>
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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
                      <a type="button" class="nav-link" onclick="abrirTabelaUsuario()" >Usuarios</a>
                  </li>
                  
                </ul>
            </div>    
      </nav>
      <!-- barra de navegação --> 
      <h2>Tabela de Produtos</h2>
        <!-- Barra de pesquisa e button que chama modal -->
      <div class="barraPesquisa">
        <input  id="searchbar" type="input" class="form-control w-25 m-1" placeholder="Buscar" aria-label="Search" aria-describedby="search-addon"/>
        <button type="button" class="btn btn-outline-primary m-1" onclick="produto.pesquisa()">Buscar</button>
        <button id="botaoModal" type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Novo Produto</button>
        
      </div>
        
        <!-- Tabela -->
        <div>
          <table class="table table-striped ">
            <thead>
                <th class="th">ID</th>
                <th class="th">Nome Produto</th>
                <th class="th">Preco Produto</th>
                <th class="th">Quantidade</th>
                <th class="th">Opçoes</th>
            </thead>
            <tbody id="tbody">
              <?php 
              if (count($produtos)==0){
                echo "<tr><td>sem produtos</td></tr>";

              }
              else{
                foreach($produtos as $produto){
                  echo "<tr>
                  <td>".$produto->id."</td>
                  <td>".$produto->nome."</td>
                  <td>".$produto->preco."</td>
                  <td>".$produto->quantidade."</td>
                  <td><button id='botaoModal' type='button' data-bs-toggle='modal' data-bs-target='#exempleModal' class='buttonEditar'
                  onclick='produto.editar(\"" . str_replace('"','\"', json_encode($produto)) . "\")'>Editar</button></td>
                  </tr>";
                }
              }
              ?>
            </tbody>
        </table>
        </div>
    </div>


      <!-- Modal de cadastro-->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produto</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/sulvale1/tabela.php" method="post">
            <div class="modal-body">
              <input type="hidden" id="id" name="id" value="">
              <div class="row label">               
                    <label >Nome Produto</label>
                    <input name="produto1" class="inputTamanho" type="text"  id="produto" value="" placeholder="Nome" required>
              </div>                
                <div class="row label">               
                  <label class="label">Preço Produto</label>
                  <input name="preco1" class="inputTamanho" type="number"  id="preco" value="" placeholder="Preço" required>                  
              </div>
              <div class="row label">
                    <label class="label">Quantidade</label>
                    <input name="quantidade1" class="inputTamanho" type="number"  id="quantidade" value="" placeholder="Quantidade" required>  
             </div>
          </div>
              <div class="modal-footer">
              <button type="reset" id="btnCancelar" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>  
              <button onclick="produto.limpar()" type="reset"  id="btnLimpar" class="btn btn-primary">Limpar</button>
              <button onclick="produto.salvar()" type="button" id="btnAdicionar" class="btn btn-primary">Salvar</button>
              <input type="submit" value="enviar">            
            </div>            
            </div>
            </form>
          </div>
          
        </div>
</body>

</html>
  
</div>
<script>
  
     class Produto{

    constructor(){
      this.id= 1;
      this.arrayProdutos=[];
      this.editId=null;
    }
     
  pesquisa() {
    const termoPesquisa = document.getElementById('searchbar').value.toLowerCase().trim();

      if(termoPesquisa===""){
            this.listaTabela(produto.arrayProdutos);
            return true;
          }
    const resultados = produto.arrayProdutos.filter((produto) =>
    produto.nomeProduto.toLowerCase()===(termoPesquisa)
    );
    if(resultados===undefined || resultados.length==0){
        alert("Nenhum produto cadastrado com esse nome!");
        return true;
      }
     
    produto.listaTabela(resultados);
    //console.log(termoPesquisa);
    }
       
    // Funcion que envia informacoes cadastradas para a tabela
    salvar(){
        let produto=this.lerDados();
        
         if(this.validaCampos(produto)){
          if (this.editId==null){
            this.adicionar(produto);
          }
          else{
            this.atualizar(this.editId,produto);
          }
           
         }
        this.listaTabela(this.arrayProdutos);
        this.limpar();
    }
    // Funcion que cria as array e linhas da tabela 
    // listaTabela(produtos){
    //   let tbody=document.getElementById('tbody');
    //   tbody.innerText ='';

    //   if(produtos===undefined || produtos.length==0){
        
    //     let tr=tbody.insertRow();

    //     let td_Id =tr.insertCell();
    //     let td_Produto =tr.insertCell();
    //     let td_Preco =tr.insertCell();
    //     let td_Quantidade =tr.insertCell();
    //     let td_Opcoes =tr.insertCell();

    //     td_Id.classList.add('listaScript');
    //     td_Produto.classList.add('listaScript');
    //     td_Preco.classList.add('listaScript');
    //     td_Quantidade.classList.add('listaScript');
    //     td_Opcoes.classList.add('listaScript');

    //     td_Id.innerText=("null");
    //     td_Produto.innerText=("Nenhum produto");
    //     td_Preco.innerText=("Nenhum preço");
    //     td_Quantidade.innerText=("Nenhuma quantidade");
    //   }
    //   console.log(produtos)
    //   for(let i= 0; i < produtos.length; i++){
    //     let tr=tbody.insertRow();

    //     let td_Id =tr.insertCell();
    //     let td_Produto =tr.insertCell();
    //     let td_Preco =tr.insertCell();
    //     let td_Quantidade =tr.insertCell();
    //     let td_Opcoes =tr.insertCell();

    //     td_Id.classList.add('listaScript');
    //     td_Produto.classList.add('listaScript');
    //     td_Preco.classList.add('listaScript');
    //     td_Quantidade.classList.add('listaScript');
    //     td_Opcoes.classList.add('listaScript');
        
    //     td_Id.innerText=produtos[i].id;
    //     td_Produto.innerText=produtos[i].nomeProduto;
    //     td_Preco.innerText=produtos[i].preco;
    //     td_Quantidade.innerText=produtos[i].quandidade;
                
    //     var buttonEditar = document.createElement('button');
    //     buttonEditar.setAttribute("data-bs-toggle","modal");
    //     buttonEditar.setAttribute("data-bs-target","#exampleModal");
    //     buttonEditar.setAttribute("onclick","produto.editar("+JSON.stringify(produtos[i])+")");
    //     td_Opcoes.appendChild(buttonEditar);
    //     buttonEditar.appendChild(document.createTextNode('Editar'));
    //     buttonEditar.classList.add('buttonEditar');
        
    //     var buttonExcluir = document.createElement('button');
    //     buttonExcluir.setAttribute("onclick","produto.excluir("+produtos[i].id+")");
    //     buttonExcluir.appendChild(document.createTextNode('Excluir'));
    //     td_Opcoes.appendChild(buttonExcluir);
    //     buttonExcluir.classList.add('buttonExcluir');
        
    //   }
    // }


    editar(dados){
      this.editId=dados.id;
      //console.log(dados);
        
      document.getElementById('produto').value=dados.nomeProduto;
      document.getElementById('preco').value=dados.preco;
      document.getElementById('quantidade').value=dados.quandidade;
      document.getElementById('id').value=dados.id;
      }


    atualizar(id,produto){ 
        for (let i=0; i<this.arrayProdutos.length;i ++){
            if(this.arrayProdutos[i].id==id){
              this.arrayProdutos[i].nomeProduto=produto.nomeProduto;
              this.arrayProdutos[i].preco=produto.preco;
              this.arrayProdutos[i].quandidade=produto.quandidade;
            }
        }
      }
    //Funcion que adiciona os dados na array
    adicionar(produto){
      this.arrayProdutos.push(produto);
      this.id++;
     }
    //Funcion que le os dados digitados na modal de cadastro
    lerDados(){
      let produto = {}
      
      produto.id=this.id;
      produto.nomeProduto = document.getElementById("produto").value.trim();
      produto.preco = document.getElementById("preco").value.trim();
      produto.quandidade = document.getElementById("quantidade").value.trim();

      return produto;
      }
    //Funcion que valida os campos e chama um alert se os dados nao foram preenchidos corretamente
    validaCampos(produto){
       let msg= "";

       if (produto.nomeProduto == ''){
         msg+="- Informe o nome do produto\n"
       }
       if (produto.preco == ''){
         msg+="- Informe o Preco do produto\n"
       }
       if (produto.quandidade == ''){
         msg+="- Informe o Quandidade do produto \n"
       }
       if (msg !=""){
         alert(msg);
         return false
       }

       return true;
      }
    //Funcion que limpa os campos da modal de cadastro
    limpar(){
      document.getElementById("produto").value='';
      document.getElementById("preco").value='';
      document.getElementById("quantidade").value='';
     }

     excluir(id){
      if(confirm('Deseja excluir o produto do ID ' +id)){

        let tbody=document.getElementById('tbody');

        for(let i= 0; i < this.arrayProdutos.length; i++){
          if(this.arrayProdutos[i].id == id){
            this.arrayProdutos.splice(i,1);
            tbody.deleteRow(i);
          }
        } 
    }
      
     }
}
var produto = new Produto();

  function abrirCadastro() {
    window.location.href = "cadastro.html";
  }
  function abrirLogin() {
    window.location.href = "index.php";
  }
  function abrirTabelaUsuario() {
    window.location.href = "tabelaUsuario.php";
  }

// produto.listaTabela();

</script>