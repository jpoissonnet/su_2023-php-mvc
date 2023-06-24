<?php

namespace App\Routing;

use Twig\Environment;

class Router
{
    private array $routes = [];
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->loadRoutes();
    }


    private function loadRoutes()
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('pages'));
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }

            $filePath = $file->getPathname();
            $relativePath = substr($filePath, strpos($filePath, 'pages') + 6);
            $url = rtrim($relativePath, '.php');

            $this->addRoute($url, $url, 'GET', $filePath, 'index');
        }
    }

    public function addRoute(
        string $name,
        string $url,
        string $httpMethod,
        string $controllerClass,
        string $controllerMethod
    )
    {
        $this->routes[$url] = [
            'name' => $name,
            'url' => $url,
            'httpMethod' => $httpMethod,
            'controllerClass' => $controllerClass,
            'controllerMethod' => $controllerMethod,
        ];
    }

    public function getRoute(string $url): ?array
    {
        return $this->routes[$url] ?? null;
    }

    public function execute()
    {
        $url = $_SERVER['REQUEST_URI'];
        $route = $this->getRoute($url);

        if ($route) {
            $controllerClass = $route['controllerClass'];
            $controllerMethod = $route['controllerMethod'];

            // Instantiate the controller class
            $controller = new $controllerClass($this->twig);

            // Call the controller method
            $controller->$controllerMethod();
        } else {
            // Route not found, handle accordingly (e.g., show a 404 page)
        }
    }
}
