<?php
use Doctrine\ORM\EntityManagerInterface;
use PHLAK\Config\Config;

define('ROOT_DIR' , realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
require_once ROOT_DIR . "/vendor/autoload.php";

$config = new Config(ROOT_DIR . '/config/');

if ($config->get('display_errors')) {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
    ini_set('display_startup_errors', true);
}

if ($config->get('log_errors')) {

    $logFilePath = ROOT_DIR . "/var/logs/error.log";

    if (!file_exists($logFilePath) && file_put_contents($logFilePath, '') === false) {
        throw new \Exception('Unable to create the create the log file');
    }

    ini_set("log_errors", 1);
    ini_set("error_log", $logFilePath);
}

define('BASE_URL', $config->get('base_url'));
$entityManager = require_once ROOT_DIR . "/database.php";

// session
session_start();

$app = new \App\Application(new \sgoranov\Dendroid\DependencyInjection\PHPDIContainer());
$app->getContainer()->set(EntityManagerInterface::class, $entityManager);

$app->start();
$app->shutDown();