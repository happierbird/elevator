<?php
require_once __DIR__ . '/app/TinyKernel.php';

use Elevator\Services\DestinationProducer;
use Elevator\Services\ConfigurationReader;
use Elevator\Services\Logger;

if (empty($argv[1])) {
    echo "Please specify the floor number!\n";
    exit;
}

$config = ConfigurationReader::readFromJsonFile(__DIR__ . '/app/config/elevator-config.json');

$producer = new DestinationProducer($config, new Logger);
$producer->pushDestination($argv[1]);
