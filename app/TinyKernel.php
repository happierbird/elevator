<?php
require_once __DIR__ . '/../src/AutoLoader.php';
require_once __DIR__.'/../vendor/autoload.php';

use Elevator\AutoLoader;

$autoloader = new AutoLoader();

$autoloader->addPrefix('Elevator\\',  dirname(__FILE__) . '/../src');
$autoloader->addPrefix('Elevator\\',  dirname(__FILE__) . '/../vendor');

$autoloader->register();