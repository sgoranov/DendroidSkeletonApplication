<?php
/*

vendor/bin/doctrine orm:schema-tool:create --dump-sql
vendor/bin/doctrine orm:schema-tool:drop --force
vendor/bin/doctrine orm:schema-tool:create
vendor/bin/doctrine orm:schema-tool:update --force

*/
require_once __DIR__ . "/vendor/autoload.php";

$entityManager = require_once __DIR__ . "/database.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
