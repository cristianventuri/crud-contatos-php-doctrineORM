<?php

namespace Cristian\CrudDoctrine\App\View;

use Cristian\CrudDoctrine\App\Model\ModelContato;
use Cristian\CrudDoctrine\App\Model\ModelPessoa;
use stdClass;

class ViewContato extends ViewBase{

  private array $contatos = [];

  public function __construct($sNomePagina = '', $aContatos = []){
    parent::__construct($sNomePagina);
    $this->contatos = $aContatos;
  }
  
  public function setContatos($aContatos){
    $this->contatos = $aContatos;
  }

  public function renderConteudo(){
    include_once 'ViewNavPrincipal.php';

    ob_start();
    ?>
    <section class="contato">

      <div class="formulario formulario-adicionar-contato">
        <h3>Adicionar Contato </h3>
        
        <form action="/contato/insere" method="post">
          <div class="mb-3">
            <label for="idPessoaContato" class="form-label">Pessoa:</label>
            <select name="id_pessoa" id="idPessoaContato" class="form-select">
              <?php
                $oModelPessoa = new ModelPessoa();
                $aModelPessoa = $oModelPessoa->buscaDados();
                foreach($aModelPessoa as $oPessoa){
                  echo '<option value="'. $oPessoa->getId() .'">'.  $oPessoa->getNome() .'</option>';
                }
              ?>
           </select>
          </div>
          <div class="mb-3">
            <label for="tipoContato" class="form-label">Tipo:</label>
            <select name="tipo" id="tipoContato" class="form-select">
              <option value="0">Telefone</option>
              <option value="1">E-mail</option>
           </select>
          </div>
          <div class="mb-3">
            <label for="descricaoContato" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricaoContato" aria-describedby="descricaoContato" name="descricao" required>
          </div>
          <button type="submit" class="btn btn-danger" onclick="ViewContato.cancelaAlteracao()">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </form>
      </div>
      
      <div class="formulario formulario-alterar-contato">
        <h3>Alterar Contato: </h3>
        
        <form action="/contato/update" method="post">
          <div class="mb-3">
            <label for="idAlteracaoContato" class="form-label">ID:</label>
            <input type="number" class="form-control" id="idAlteracaoContato" aria-describedby="idAlteracaoContato" name="id" required readonly>
          </div>
          <div class="mb-3">
            <label for="idAlteracaoPessoaContato" class="form-label">Pessoa:</label>
            <select name="id_pessoa" id="idAlteracaoPessoaContato" class="form-select" readonly="readonly" tabindex="-1" aria-disabled="true">
              <?php
                $oModelPessoa = new ModelPessoa();
                $aModelPessoa = $oModelPessoa->buscaDados();
                foreach($aModelPessoa as $oPessoa){
                  echo '<option value="'. $oPessoa->getId() .'">'.  $oPessoa->getNome() .'</option>';
                }
              ?>
           </select>
          </div>
          <div class="mb-3">
            <label for="tipoAlteracaoContato" class="form-label">Tipo:</label>
            <select name="tipo" id="tipoAlteracaoContato" class="form-select">
              <option value="0">Telefone</option>
              <option value="1">E-mail</option>
           </select>
          </div>
          <div class="mb-3">
            <label for="descricaoAlteracaoContato" class="form-label">Descrição:</label>
            <input type="text" class="form-control" id="descricaoAlteracaoContato" aria-describedby="descricaoAlteracaoContato" name="descricao" required>
          </div>
          <button type="submit" class="btn btn-danger" onclick="ViewContato.cancelaAlteracao()">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </form>
      </div>
      
      <div class="conteudo-tabela">
        <h3>Consulta de Contatos: </h3>

        <form class="input-group" action="/contato" method="get">
          <input type="text" class="form-control" id="filtroNome" placeholder="Filtrar por nome de pessoa" aria-describedby="filtroNome" name="filtro" value="<?= (isset($_GET['filtro']) && !empty($_GET['filtro']) ? $_GET['filtro'] : ''); ?>">
          <button class="btn btn-outline-primary" type="submit" id="Filtrar" onsubmit="">Filtrar</button>
        </form>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID:</th>
              <th scope="col">ID Pessoa:</th>
              <th scope="col">Nome:</th>
              <th scope="col">Tipo:</th>
              <th scope="col">Descriçao:</th>
              <th scope="col">Ações:</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach($this->contatos as $oModelContato){
              /** @var ModelContato $oModelContato*/

              $oModelPessoa = new ModelPessoa();
              $oModelPessoa = $oModelPessoa->buscaDadosPorId($oModelContato->getPessoa());
              $sTipoContato = ($oModelContato->getTipo() == false) ? "Telefone" : "E-mail";

              $oContato = new stdClass();
              $oContato->id = $oModelContato->getId();
              $oContato->tipo = $oModelContato->getTipo();
              $oContato->descricao = $oModelContato->getDescricao();
              $oContato->id_pessoa = $oModelContato->getPessoa();

              if($oModelPessoa){
                echo '<tr>';
                echo '<th scope="row"> ' . $oModelContato->getId() . ' </th>';
                echo '<td> ' . $oModelContato->getPessoa() . ' </td>';
                echo '<td> ' . $oModelPessoa->getNome() . ' </td>';
                echo '<td> ' . $sTipoContato . ' </td>';
                echo '<td> ' . $oModelContato->getDescricao() . ' </td>';
                echo '<td class="action">';
                echo '<button type="button" class="btn btn-warning" onclick=\'ViewContato.alterarContato(' . json_encode($oContato) . ')\'>Editar</button>';
                echo '<a href="/contato/delete?id=' . $oModelContato->getId() . '" type="button" class="btn btn-danger">Excluir</a>';
                echo '</td>';
                echo '</tr>';
              }
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
      .contato{
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
      .formulario-alterar-contato{
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
        ViewContato = {};

        ViewContato.cancelaAlteracao = () => {
          const oFormAlterar = document.querySelector('.formulario-alterar-contato');
          const oFormAdicionar = document.querySelector('.formulario-adicionar-contato');
          oFormAdicionar.style.display = 'flex';
          oFormAlterar.style.display = 'none';
        };

        ViewContato.alterarContato = (oContato) => {
          ViewContato.cancelaAlteracao();
          
          const oFormAlterar = document.querySelector('.formulario-alterar-contato');
          const oFormAdicionar = document.querySelector('.formulario-adicionar-contato');
          
          const oInputId = oFormAlterar.querySelector('input#idAlteracaoContato');
          oInputId.value = oContato.id || '';
          const oIdPessoa = oFormAlterar.querySelector('select#idAlteracaoPessoaContato');
          oIdPessoa.value = oContato.id_pessoa || '';
          const oInputTipo = oFormAlterar.querySelector('select#tipoAlteracaoContato');
          oInputTipo.value = oContato.tipo ? 1 : 0;
          const oInputDescricao = oFormAlterar.querySelector('input#descricaoAlteracaoContato');
          oInputDescricao.value = oContato.descricao || '';
          
          oFormAdicionar.style.display = 'none';
          oFormAlterar.style.display = 'flex';
        };
      </script>
    <?php
    echo ob_get_clean();
  }

}