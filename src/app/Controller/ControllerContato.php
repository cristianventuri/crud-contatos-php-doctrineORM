<?php

namespace Cristian\CrudDoctrine\App\Controller;

use Cristian\CrudDoctrine\App\Model\ModelContato;
use Cristian\CrudDoctrine\App\Model\ModelPessoa;
use Cristian\CrudDoctrine\App\View\ViewContato;

class ControllerContato implements InterfaceRequisicao {

  public function processaRequisicao($processo = null) {
    $oTela = $this->getInstanciaTela();

    switch ($processo) {
      case 'insere':
        $this->processaDadosInsere();
        break;
      case 'delete':
        $this->processaDadosDelete();
        break;
      case 'update':
        $this->processaDadosUpdate();
        break;
        
      default:
          if(!(empty($_GET['filtro'])) && (isset($_GET['filtro'])) && ($sFiltro = $_GET['filtro'])){
            $oModelPessoa = new ModelPessoa();
            $aPessoas = $oModelPessoa->buscaDadosPor('nome', $sFiltro);
            $aIdPessoas = [];
            foreach($aPessoas as $oPessoa){
              $aIdPessoas = $oPessoa->getId();
            }
            
            $oModelPessoa = new ModelContato();
            $oTela->setContatos($oModelPessoa->buscaDadosPor('pessoa_id', $aIdPessoas));
          } else {
            $oTela->setContatos($this->getContatos());
          }
        break;
    }

    $oTela->montaHtml();
  }

  /**
   * Busca todos os contatos
   * 
   * @return array
   */
  private function getContatos(){
    $oModelContato = new ModelContato();
    return $oModelContato->buscaDados();
  }

  /**
   * Retorna a instancia de Tela;
   * 
   * @return ViewContato
   */
  protected function getInstanciaTela(){
    return new ViewContato('Visualização de Contato');
  }

  /**
   * Processa os dados de inserção
   */
  private function processaDadosInsere(){
    $sPostIdPessoa  = isset($_POST['id_pessoa']) && !empty($_POST['id_pessoa']) ? $_POST['id_pessoa'] : null;
    $sPostDescricao = isset($_POST['descricao']) && !empty($_POST['descricao']) ? $_POST['descricao'] : null;
    $sPostTipo      = isset($_POST['tipo']) ? $_POST['tipo'] : null;

    if($sPostIdPessoa && !is_null($sPostTipo) && $sPostDescricao){
      $oModelContato = new ModelContato();
      $oModelContato->setPessoa($sPostIdPessoa);
      $oModelContato->setTipo($sPostTipo);
      $oModelContato->setDescricao($sPostDescricao);
      $oModelContato->insere();
    }

    header("Location: /contato");
  }

   /**
   * Processa os dados de Alteração
   */
  private function processaDadosUpdate(){
    $sPostId        = isset($_POST['id'])        && !empty($_POST['id'])        ? $_POST['id'] : null;
    $sPostIdPessoa  = isset($_POST['id_pessoa']) && !empty($_POST['id_pessoa']) ? $_POST['id_pessoa'] : null;
    $sPostDescricao = isset($_POST['descricao']) && !empty($_POST['descricao']) ? $_POST['descricao'] : null;
    $sPostTipo      = isset($_POST['tipo']) ? $_POST['tipo'] : null;

    if($sPostId && $sPostIdPessoa && !is_null($sPostTipo) && $sPostDescricao){
      $oModelContato = new ModelContato();
      $oModelContato->setId($sPostId);
      $oModelContato->setPessoa($sPostIdPessoa);
      $oModelContato->setTipo($sPostTipo);
      $oModelContato->setDescricao($sPostDescricao);
      $oModelContato->update();
    }

    header("Location: /contato");
  }

   /**
   * Processa os dados de Exclusão
   */
  private function processaDadosDelete(){
    $iId = isset($_GET['id'])  && !empty($_GET['id'])  ? $_GET['id'] : false;

    if($iId){
      $oModelContato = new ModelContato();
      $oModelContato->setId($iId);
      $oModelContato->delete();
    }
    
    header("Location: /contato");
  }

};
