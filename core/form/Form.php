<?php

declare(strict_types=1);

namespace app\core\form;

use app\core\Model;
use app\core\Router;

class Form
{
    public static function begin(
        string $action = '',
        string $method = Router::METHOD_POST,
        string $class = ''
    ): self {
        echo sprintf(
            '<form action="%s" method="%s" class="%s">',
            $action,
            $method,
            $class
        );
        return new self();
    }

    public static function end(): string
    {
        return '</form>';
    }

    public function input(string $type, Model $model, string $attribute): Field
    {
        return new Field($type, $model, $attribute);
    }

    public function submitButton(string $class = 'btn-primary'): string
    {
        return sprintf(
            '<input type="submit" class="btn %s" value="Submit">',
            $class
        );
    }
}
