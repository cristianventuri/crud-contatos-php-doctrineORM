<?php

namespace Cristian\CrudDoctrine\App\View;

abstract class ViewBase {

  private string $nomePagina;
  
  public function __construct($sNomePagina = ''){
    $this->nomePagina = $sNomePagina;
  }

  public function montaHtml() { 
    $this->abreHtml();

    $this->abreHead();
    $this->fechaHead();

    $this->abreBody();
    $this->renderEstilo();
    $this->renderEstiloBase();
    $this->renderConteudo();
    $this->renderComportamento();
    $this->renderComportamentoBase();
    $this->fechaBody();

    $this->fechaHtml();
  }
  
  /**
   * Imprime a abertura da Tag HTML
   */
  protected function abreHtml(){
    echo '<!DOCTYPE html>';
    echo '<html lang="pt-BR">';
  }

  /**
   * Imprime a abertura da Tag HEAD
   */
  protected function abreHead(){
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo "<title>{$this->getTituloPagina()}</title>";
  }
  
  /**
   * Imprime a abertura da Tag BODY
   */
  protected function abreBody(){
    echo '<body>';
  }
  
  /**
   * Imprime o fechamento da Tag HTML
   */
  protected function fechaHtml(){
    echo ' </html>';
  }
  
  /**
   * Imprime o fechamento da Tag HEAD
   */
  protected function fechaHead(){
    echo '</head>';
  }
  
  /**
   * Imprime o fechamento da Tag BODY
   */
  protected function fechaBody(){
    echo '</body>';
  }

  /**
   * Injeta o conteudo principal no BODY da página
   */
  abstract protected function renderConteudo();

  /**
   * Injeta o JS no BODY da página
   */
  protected function renderComportamento(){}

  /**
   * Injeta o JS no BODY da página
   */
  protected function renderComportamentoBase(){
    echo '<script>';
      require_once 'Comportamentos/ViewComportamentoBootstrap.js';
    echo '</script>';
  }

  /**
   * Injeta o CSS no BODY da página
   */
  protected function renderEstilo(){}

  /**
   * Injeta o CSS no BODY da página
   */
  protected function renderEstiloBase(){
    echo '<style>';
      require_once 'Estilos/ViewEstiloBootstrap.css';
    echo '</style>';
  }

  /**
   * Retorna o title da página
   * @return string 
   */
  public function getTituloPagina(){
    return $this->nomePagina ?: 'Gestão de Contatos';
  }
  
}