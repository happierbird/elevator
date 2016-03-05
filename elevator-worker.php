<?php
require_once __DIR__ . '/app/TinyKernel.php';

use Elevator\Services\ElevatorWorker;
use Elevator\Services\ConfigurationReader;
use Elevator\Services\Logger;

$config = ConfigurationReader::readFromJsonFile(__DIR__ . '/app/config/elevator-config.json');

$worker = new ElevatorWorker($config['MQConnection'], new Logger);
$worker->consumeDestinations();
