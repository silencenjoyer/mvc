<?php

declare(strict_types=1);

use app\core\MVC;

require_once __DIR__ . '/../vendor/autoload.php';

$app = MVC::getInstance(dirname(__DIR__));

$app->router->get('/', 'homepage');
$app->router->get('/feedback', 'feedback');

$app->run();
