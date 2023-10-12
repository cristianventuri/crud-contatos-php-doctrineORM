<?php

namespace Cristian\CrudDoctrine\App\Controller;

use Cristian\CrudDoctrine\App\Model\ModelPessoa;
use Cristian\CrudDoctrine\App\View\ViewPessoa;

class ControllerPessoa implements InterfaceRequisicao {

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
          $oPessoas = $oModelPessoa->buscaDadosPor('nome', $sFiltro);
          $oTela->setPessoas($oPessoas);
        } else {
          $oTela->setPessoas($this->getPessoas());
        }
        break;
    }

    $oTela->montaHtml();
  }

  /**
   * Retorna a instacia de tela
   * 
   * @return ViewPessoa;
   */
  protected function getInstanciaTela(){
    return new ViewPessoa('Visualização de Pessoa');
  }

  /**
   * Retornar todas as pessoas
   * 
   * @return array
   */
  private function getPessoas(){
    $oModelPessoa = new ModelPessoa();
    return $oModelPessoa->buscaDados();
  }

   /**
   * Processa os dados de inserção
   */
  private function processaDadosInsere(){
    $sPostName = isset($_POST['nome']) && !empty($_POST['nome']) ? $_POST['nome'] : false;
    $sPostCPF  = isset($_POST['cpf'])  && !empty($_POST['cpf'])  ? $_POST['cpf'] : false;

    if($sPostName && $sPostCPF){
      $oModelPessoa = new ModelPessoa();
      $oModelPessoa->setNome($sPostName);
      $oModelPessoa->setCpf($sPostCPF);
      $oModelPessoa->insere();
    }
    
    header("Location: /pessoa");
  }

   /**
   * Processa os dados de exclusão
   */
  private function processaDadosDelete(){
    $iId = isset($_GET['id'])  && !empty($_GET['id'])  ? $_GET['id'] : false;

    if($iId){
      $oModelPessoa = new ModelPessoa();
      $oModelPessoa->setId($iId);
      $oModelPessoa->delete();
    }
    
    header("Location: /pessoa");
  }

   /**
   * Processa os dados de alteração
   */
  private function processaDadosUpdate(){
    $iPostId   = isset($_POST['id'])  && !empty($_POST['id'])  ? $_POST['id'] : false;
    $sPostName = isset($_POST['nome']) && !empty($_POST['nome']) ? $_POST['nome'] : false;
    $sPostCPF  = isset($_POST['cpf'])  && !empty($_POST['cpf'])  ? $_POST['cpf'] : false;

    if($iPostId && $sPostName && $sPostCPF){
      $oModelPessoa = new ModelPessoa();
      $oModelPessoa->setId($iPostId);
      $oModelPessoa->setNome($sPostName);
      $oModelPessoa->setCpf($sPostCPF);
      $oModelPessoa->update();
    }
    
    header("Location: /pessoa");
  }
};
