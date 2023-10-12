<?php

namespace Cristian\CrudDoctrine\App\Helper;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

require __DIR__ . '/../../../vendor/autoload.php';

class EntityManagerFactory {

    /**
   * @return EntityManagerInterface
   * @throws \Doctrine\ORM\ORMException
   */
  public function getEntityManager() {
    $sRootDir = __DIR__ . '/../..';
    $bIsDevMode = true;
    $sProxyDir = null;
    $bUseCache = null;
    $bUseSimpleAnnotationReader = false;

    $oConf = Setup::createAnnotationMetadataConfiguration(
      [$sRootDir], 
      $bIsDevMode,
      $sProxyDir,
      $bUseCache,
      $bUseSimpleAnnotationReader
    );

    $oConnection = [
      'driver' => 'pdo_sqlite',
      'path' => $sRootDir . '/../config/db.sqlite',
    ];

    /* Para utilizar com MySQL, é necessário possuir a instalação do MySQL server,
     * criar o database "crud_doctrine" e configurar os dados da conexão abaixo e descomentar o trecho de codigo;
     */
    // $oConnection = [ 
    //   'driver' => 'pdo_mysql',
    //   'host' => 'localhost',
    //   'dbname' => 'crud_doctrine',
    //   'user' => 'root',
    //   'password' => 'root'
    // ];
    
    return EntityManager::create($oConnection, $oConf);
  }
}
