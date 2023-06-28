<?php

namespace App\Middleware;


class Guard
{
    private readonly array $routes;
    private int $guardLevel = 0;

    public function addRoute($newRoute)
    {
        $this->routes[] = $newRoute;
    }

    public function check($route)
    {
        //TODO: get user guardLevel
        if ($route["guardLevel"] > $this->guardLevel) {
            header('HTTP/1.0 403 Forbidden');
            die("Forbidden acces");
        }
    }

}
