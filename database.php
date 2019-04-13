<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use PHLAK\Config\Config;

$config = new Config(__DIR__ . '/config/');

return EntityManager::create($config->get('database'), Setup::createAnnotationMetadataConfiguration(
    array(__DIR__ . "/app"),
    true, // $isDevMode
    null, // $proxyDir
    null, // $cache
    false // $useSimpleAnnotationReader
));
