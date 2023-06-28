<?php

namespace App\Routing;

use App\Controller\IndexController;
use App\Controller\PageController;
use App\Middleware\Guard;
use Psr\Container\ContainerInterface;
use ReflectionException;
use ReflectionMethod;

class Router
{
  public function __construct(
    private readonly ContainerInterface $container
  ) {
      $this->addRoute(
          'homepage',
          '/',
          'GET',
          IndexController::class,
          'home'
      );
      $this->loadRoutes();
  }

  private array $routes = [];

  public function addRoute(
    string $name,
    string $url,
    string $httpMethod,
    string $controllerClass,
    string $controllerMethod,
    int $guardLevel = 0
  ) {
      $newRoute = [
      'name' => $name,
      'url' => $url,
      'http_method' => $httpMethod,
      'controller' => $controllerClass,
      'method' => $controllerMethod,
          'guardLevel' => $guardLevel
    ];
      $this->routes[] = $newRoute;

  }

    private function loadRoutes()
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('pages'));
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $url = rtrim($file->getBaseName(), '.php');
            $this->addRoute($url, "/" . $url, 'GET', PageController::class, 'response');
        }
    }

  public function getRoute(string $uri, string $httpMethod): ?array
  {
    foreach ($this->routes as $route) {
      if ($route['url'] === $uri && $route['http_method'] === $httpMethod) {
        return $route;
      }
    }

    return null;
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

        $controllerClass = $route['controller'];

        if($this->container->has(Guard::class)) {
            $guard = $this->container->get(Guard::class);
            $guard->check($route);
        }

        $method = $route['method'];

    $constructorParams = $this->getMethodParams($controllerClass . '::__construct');
    $controllerInstance = new $controllerClass(...$constructorParams);

    $controllerParams = $this->getMethodParams($controllerClass . '::' . $method);
    echo $controllerInstance->$method(...$controllerParams);
  }

  /**
   * Get an array containing services instances guessed from method signature
   *
   * @param string $method Format : FQCN::method
   * @return array The services to inject
   */
  private function getMethodParams(string $method): array
  {
    $params = [];

    try {
      $methodInfos = new ReflectionMethod($method);
    } catch (ReflectionException $e) {
      return [];
    }
    $methodParams = $methodInfos->getParameters();

    foreach ($methodParams as $methodParam) {
      $paramType = $methodParam->getType();
      $paramTypeName = $paramType->getName();
      $params[] = $this->container->has($paramTypeName) ? $this->container->get($paramTypeName) : null;
    }

    return $params;
  }
}
