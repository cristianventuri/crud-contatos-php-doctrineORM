<?php

use Cristian\CrudDoctrine\App\Helper\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/../vendor/autoload.php';

$oEntityManagerFactory = new EntityManagerFactory();
$oEntityManager = $oEntityManagerFactory->getEntityManager();

return ConsoleRunner::createHelperSet($oEntityManager);