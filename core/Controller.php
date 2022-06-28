<?php

declare(strict_types=1);

namespace app\core;

class Controller
{
    public function render(string $view, ?array $params = null): string
    {
        return MVC::$app->router->render($view, $params);
    }
}