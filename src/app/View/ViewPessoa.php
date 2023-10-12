<?php

namespace Cristian\CrudDoctrine\App\View;

use Cristian\CrudDoctrine\App\Model\ModelPessoa;
use stdClass;

class ViewPessoa extends ViewBase{

  private array $pessoas = [];

  public function __construct($sNomePagina = '', $aPessoas = []){
    parent::__construct($sNomePagina);
    $this->pessoas = $aPessoas;
  }
  
  public function setPessoas($aPessoas){
    $this->pessoas = $aPessoas;
  }

  public function renderConteudo(){
    include_once 'ViewNavPrincipal.php';

    ob_start();
    ?>
    <section class="pessoa">
      <div class="formulario formulario-inclusao">
        <h3>Cadastrar Pessoa: </h3>
        
        <form action="/pessoa/insere" method="post">
          <div class="mb-3">
            <label for="nomePesso" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nomePessoa" aria-describedby="nomePessoa" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="cpfPessoa" class="form-label">CPF:</label>
            <input type="number" class="form-control" id="cpfPessoa" aria-describedby="cpfPessoa" name="cpf" required>
          </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </div>
      
      <div class="formulario formulario-alteracao">
        <h3>Editar Pessoa: </h3>
        
        <form action="/pessoa/update" method="post">
          <div class="mb-3">
            <label for="idAlteracaoPessoa" class="form-label">ID:</label>
            <input type="number" class="form-control" id="idAlteracaoPessoa" aria-describedby="idAlteracaoPessoa" name="id" required readonly>
          </div>
          <div class="mb-3">
            <label for="nomeAlteracaoPessoa" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nomeAlteracaoPessoa" aria-describedby="nomeAlteracaoPessoa" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="cpfAlteracaoPessoa" class="form-label">CPF:</label>
            <input type="number" class="form-control" id="cpfAlteracaoPessoa" aria-describedby="cpfAlteracaoPessoa" name="cpf" required>
          </div>
          <button type="submit" class="btn btn-danger" onclick="ViewPessoa.cancelaAlteracao()">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </form>
      </div>

      <div class="formulario formulario-adicionar-contato">
        <h3>Adicionar Contato </h3>
        
        <form action="/contato/insere" method="post">
          <div class="mb-3">
            <label for="idPessoaContato" class="form-label">ID:</label>
            <input type="number" class="form-control" id="idPessoaContato" aria-describedby="idPessoaContato" name="id_pessoa" required readonly>
          </div>
          <div class="mb-3">
            <label for="nomePessoaContato" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nomePessoaContato" aria-describedby="nomePessoaContato" name="nome" required readonly>
          </div>
          <div class="mb-3">
            <label for="tipoPessoaContato" class="form-label">Tipo:</label>
            <select name="tipo" id="tipoPessoaContato" class="form-select">
              <option selected value="0">Telefone</option>
              <option value="0">E-mail</option>
           </select>
          </div>
          <div class="mb-3">
            <label for="descricaoPessoaContato" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricaoPessoaContato" aria-describedby="descricaoPessoaContato" name="descricao" required>
          </div>
          <button type="submit" class="btn btn-danger" onclick="ViewPessoa.cancelaAlteracao()">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </form>
      </div>
      
      <div class="conteudo-tabela">
        <h3>Consulta de Pessoa: </h3>
        
        <form class="input-group" action="/pessoa" method="get">
          <input type="text" class="form-control" id="filtroNome" placeholder="Filtrar por nome de pessoa" aria-describedby="filtroNome" name="filtro" value="<?= (isset($_GET['filtro']) && !empty($_GET['filtro']) ? $_GET['filtro'] : ''); ?>">
          <button class="btn btn-outline-primary" type="submit" id="Filtrar" onsubmit="">Filtrar</button>
        </form>
        
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID:</th>
              <th scope="col">Nome:</th>
              <th scope="col">CPF:</th>
              <th scope="col">Ações:</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($this->pessoas as $oModelPessoa){
              /** @var ModelPessoa $oModelPessoa*/

              $oPessoa =  new stdClass();
              $oPessoa->id = $oModelPessoa->getId();
              $oPessoa->nome = $oModelPessoa->getNome();
              $oPessoa->cpf = $oModelPessoa->getCpf();

              echo '<tr>';
              echo '<th scope="row"> ' . $oModelPessoa->getId() . ' </th>';
              echo '<td> ' . $oModelPessoa->getNome() . ' </td>';
              echo '<td> ' . $oModelPessoa->getCpf() . ' </td>';
              echo '<td class="action">';
              echo '<button type="button" class="btn btn-success" onclick=\'ViewPessoa.adicionaContato(' . json_encode($oPessoa) . ')\'>Adicionar Contato</button>';
              echo '<button type="button" class="btn btn-warning" onclick=\'ViewPessoa.alterarPessoa(' . json_encode($oPessoa) . ')\'>Editar</button>';
              echo '<a href="/pessoa/delete?id=' . $oModelPessoa->getId() . '" type="button" class="btn btn-danger">Excluir</a>';
              echo '</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>
    <?php
    echo ob_get_clean();
  }
  
  public function renderEstilo(){
    ob_start();
    ?>
    <style>
      .pessoa{
        display: flex;
        justify-content: center;
        gap: 10rem;
        max-width: 80vw;
        margin: 0 auto;
      }
      .formulario{
        display: flex;
        flex-direction: column;
      }
      .formulario-alteracao, .formulario-adicionar-contato{
        display: none;
      }
      .conteudo-tabela{
        flex: 1;
        display: flex;
        flex-direction: column;
      }
      .conteudo-tabela table .action{
        display: flex;
        gap: .5rem;
      }
      </style>
    <?php
    echo ob_get_clean();
  }

  public function renderComportamento(){
    ob_start();
    ?>
      <script>
        ViewPessoa = {};

        ViewPessoa.cancelaAlteracao = () => {
          const oFormInclusao = document.querySelector('.formulario-inclusao');
          const oFormAlteracao = document.querySelector('.formulario-alteracao');
          const oFormAdicionaContato = document.querySelector('.formulario-adicionar-contato');
          oFormInclusao.style.display = 'flex';
          oFormAdicionaContato.style.display = oFormAlteracao.style.display = 'none';
        };

        ViewPessoa.alterarPessoa = (oPessoa) => {
          ViewPessoa.cancelaAlteracao();
          
          const oFormInclusao = document.querySelector('.formulario-inclusao');
          const oFormAlteracao = document.querySelector('.formulario-alteracao');
          
          const oInputId = oFormAlteracao.querySelector('input#idAlteracaoPessoa');
          oInputId.value = oPessoa.id || '';
          const oInputNome = oFormAlteracao.querySelector('input#nomeAlteracaoPessoa');
          oInputNome.value = oPessoa.nome || '';
          const oInputCpf = oFormAlteracao.querySelector('input#cpfAlteracaoPessoa');
          oInputCpf.value = oPessoa.cpf || '';
          
          oFormInclusao.style.display = 'none';
          oFormAlteracao.style.display = 'flex';
        };
        
        ViewPessoa.adicionaContato = (oPessoa) => {
          ViewPessoa.cancelaAlteracao();

          const oFormInclusao = document.querySelector('.formulario-inclusao');
          const oFormContato = document.querySelector('.formulario-adicionar-contato');

          const oInputId = oFormContato.querySelector('input#idPessoaContato');
          oInputId.value = oPessoa.id || '';
          const oInputNome = oFormContato.querySelector('input#nomePessoaContato');
          oInputNome.value = oPessoa.nome || '';

          oFormInclusao.style.display = 'none';
          oFormContato.style.display = 'flex';
        };
      </script>
    <?php
    echo ob_get_clean();
  }
  
}