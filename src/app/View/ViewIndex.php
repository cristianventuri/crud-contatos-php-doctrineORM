<?php

namespace Cristian\CrudDoctrine\App\View;

class ViewIndex extends ViewBase{

  public function renderConteudo(){
    include_once 'ViewNavPrincipal.php';

    ob_start();
    ?>
    <div class="aviso-index">
      <h2>
        Esta é a página inicial do sistema, selecione o menu desejado para visualizar as informações!
      </h2>
    </div>

    <?php
    echo ob_get_clean();
  }

  public function renderEstilo(){
    ob_start();
    ?>
    <style>
      .aviso-index{
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 80px);
        color: #35363a;
      }
    </style>
    <?php
    echo ob_get_clean();
  }

}