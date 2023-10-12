<?php

namespace Cristian\CrudDoctrine\App\Controller;

use Cristian\CrudDoctrine\App\View\ViewIndex;

class ControllerIndex implements InterfaceRequisicao {

  public function processaRequisicao() {
    $oTela = $this->getInstanciaTela();
    $oTela->montaHtml();
  }

  protected function getInstanciaTela(){
    return new ViewIndex('Página Inicial');
  }

};
