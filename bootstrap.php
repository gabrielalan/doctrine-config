<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src/Entities");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_pgsql',
    'user'     => 'postgres',
    'password' => '123456',
    'dbname'   => 'postgres',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

$config->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());

$entityManager = EntityManager::create($dbParams, $config);