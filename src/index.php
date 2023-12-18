<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Adjust based on your project's autoload path

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Include route files
require __DIR__ . '/../src/routes/receipt_routes.php';

$app->run();
