<?php

declare(strict_types=1);

use app\core\MVC;
use app\controllers\SiteController;

require_once __DIR__ . '/../vendor/autoload.php';

$app = MVC::getInstance(dirname(__DIR__));

$app->router->get('/', [SiteController::class, 'homepage']);
$app->router->get('/register', [SiteController::class, 'register']);
$app->router->post('/register', [SiteController::class, 'register']);

$app->run();
