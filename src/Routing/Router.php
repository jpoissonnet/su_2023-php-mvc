<?php

namespace App\Routing;

use App\Controller\IndexController;
use App\Controller\PageController;
use Twig\Environment;

class Router
{
    private array $routes = [];
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->addRoute(
            'homepage',
            '/',
            'GET',
            IndexController::class,
            'home'
        );
        $this->loadRoutes();
    }


    private function loadRoutes()
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('pages'));
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $url = rtrim($file->getBaseName(), '.php');
            $this->addRoute($url, "/".$url, 'GET', PageController::class, 'response');
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
            throw new RouteNotFoundException($url, 404);
        }
    }
}
