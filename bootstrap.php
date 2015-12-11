<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$path = array("/path/to/entity-files");

$connectionParams = array(
    'dbname' => 'jlaynedb',
    'user' => 'jlayne',
    'password' => 'CH@ngemenow99Please!jlayne',
    'host' => 'classroom.cs.unc.edu',
    'driver' => 'pdo_mysql',
);
$config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
        /*\Doctrine\DBAL\Configuration();*/
//$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);


// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
// obtaining the entity manager
$entityManager = EntityManager::create($connectionParams, $config);
