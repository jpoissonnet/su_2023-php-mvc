<?php

namespace App\Middleware;


class Guard
{
    private array $routes;
    private int $guardLevel = 0;
    public function addRoute($newRoute)
    {
        $this->routes[] = $newRoute;
    }

    public function syncSessionGuardLevel() : int
    {
        session_start();
        if (isset($_SESSION["guardLevel"])) {
            $this->guardLevel = $_SESSION["guardLevel"];
        }
        return $this->guardLevel;
    }

    public function setSessionGuardLevel(int $newLevel){
        $this->guardLevel = $newLevel;
        $_SESSION["guardLevel"] = $newLevel;
    }

    public function check($route)
    {

        $this->syncSessionGuardLevel();
        if ($route["guardLevel"] > $this->guardLevel) {
            header('HTTP/1.0 403 Forbidden');
            die("Forbidden acces");
        }
    }



}
