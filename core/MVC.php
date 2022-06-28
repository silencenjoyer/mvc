<?php

declare(strict_types=1);

namespace app\core;

class MVC
{
    public static ?self $app = null;
    public static string $ROOT_PATH;

    private function __construct(
        public Request $request,
        public Router $router,
        public Response $response
    ) {}

    public static function getInstance(string $rootPath): static
    {
        if (!static::$app) {
            $request = new Request();
            $response = new Response();
            $router = new Router($request, $response);

            static::$app = new static(
                $request,
                $router,
                $response
            );
            static::$ROOT_PATH = $rootPath;
        }

        return static::$app;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
