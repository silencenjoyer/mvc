<?php

declare(strict_types=1);

namespace app\core;

class Response
{
    public function setStatusCode(int $code): bool
    {
        return (bool) http_response_code($code);
    }
}
