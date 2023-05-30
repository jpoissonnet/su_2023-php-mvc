<?php

namespace App\Routing;

use Twig\Environment;
use App\Controller\IndexController;
use App\Controller\PageController;

class Router
{


    private array $routes = [];

    public function __construct(private Environment $twig)
    {
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

    /**
     * @param string $requestUri
     * @param string $httpMethod
     * @return void
     * @throws RouteNotFoundException
     */
    public function execute(string $requestUri, string $httpMethod)
    {
        $route = $this->getRoute($requestUri, $httpMethod);

        if ($route === null) {
            throw new RouteNotFoundException($requestUri, $httpMethod);
        }

        $controller = $route['controller'];
        $method = $route['method'];

        $controllerInstance = new $controller();
        $controllerInstance->$method();
    }
}
