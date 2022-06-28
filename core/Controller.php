<?php

declare(strict_types=1);

namespace app\core;

class Controller
{
    public function render(string $view): string
    {
        return MVC::$app->router->render($view);
    }
}