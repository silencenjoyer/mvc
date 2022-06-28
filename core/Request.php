<?php

declare(strict_types=1);

namespace app\core;

use JetBrains\PhpStorm\Pure;

class Request
{
    public function getPath()
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $positionQuestionMark = strpos($_SERVER['REQUEST_URI'], '?');
        if ($positionQuestionMark) {
            return substr($requestUri, 0, $positionQuestionMark);
        }
        return $requestUri;
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->method() === Router::METHOD_GET;
    }

    public function isPost(): bool
    {
        return $this->method() === Router::METHOD_POST;
    }

    public function post(): array
    {
        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $body;
    }

    public function get(): array
    {
        $body = [];
        if ($this->method() === Router::METHOD_GET) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $value, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function getRequestBody(): array
    {
        if ($this->method() === Router::METHOD_POST) {
            return $this->post();
        } else {
            return $this->get();
        }
    }
}
