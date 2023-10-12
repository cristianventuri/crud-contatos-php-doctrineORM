<?php

use Cristian\CrudDoctrine\App\Controller\ControllerIndex;
use Cristian\CrudDoctrine\App\Controller\ControllerContato;
use Cristian\CrudDoctrine\App\Controller\ControllerPessoa;

require __DIR__ . '/../vendor/autoload.php';

/*
 * Busca o Path da URL
 */
$sPath = isset($_SERVER['PATH_INFO']) ? ltrim($_SERVER['PATH_INFO'], '/') : '';

try {
  $aPath = explode('/', $sPath);
} catch (\Throwable $th) {
  $aPath = ['']; 
}

switch ($aPath[0]) {
  case '':
  case 'index':
    $oControllerIndex = new ControllerIndex();
    $oControllerIndex->processaRequisicao();
    break;

  case 'pessoa':
    $oControllerPessoa =  new ControllerPessoa();
    $oControllerPessoa->processaRequisicao($aPath[1]);
    break;

  case 'contato':
    $oControllerContato = new ControllerContato();
    $oControllerContato->processaRequisicao($aPath[1]);
    break;

  default:
    echo 'erro';
    break;
}
