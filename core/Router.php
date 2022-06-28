<?php

declare(strict_types=1);

namespace app\core;

class Router
{
    public const METHOD_GET = 'get';
    public const METHOD_POST = 'post';

    public function __construct(
        public Request $request,
        public Response $response
    ) {}

    public array $routes = [
        self::METHOD_GET => [],
        self::METHOD_POST => []
    ];

    public function get(string $path, mixed $callback): void
    {
        $this->routes[self::METHOD_GET][$path] = $callback;
    }

    public function post(string $path, mixed $callback): void
    {
        $this->routes[self::METHOD_POST][$path] = $callback;
    }

    public function resolve()
    {
       $path = $this->request->getPath();
       $method = $this->request->method();
       $callback = $this->routes[$method][$path] ?? null;

       if ($callback) {
           if (is_string($callback)) {
               return $this->render($callback);
           } else {
               $callback[0] = new $callback[0]();
               return call_user_func($callback);
           }
       } else {
           return $this->notFound();
       }
    }

    public function render(string $view): string
    {
        $view = $this->renderOnlyView($view);
        if (!$view) {
            $view = $this->notFound(true);
        }
        $layout = $this->renderLayout();
        return str_replace('{{content}}', $view, $layout);
    }

    public function renderOnlyView(string $view): string
    {
        ob_start();
        include_once MVC::$ROOT_PATH . "/views/$view.php";
        return ob_get_clean() ?? '';
    }

    public function renderLayout(): string
    {
        ob_start();
        include_once MVC::$ROOT_PATH . "/views/layouts/main.php";
        return ob_get_clean() ?? '';
    }

    public function notFound(bool $partially = false): string
    {
        $this->response->setStatusCode(404);
        if ($partially) {
            return $this->renderOnlyView('404');
        } else {
            return $this->render('404');
        }
    }
}
