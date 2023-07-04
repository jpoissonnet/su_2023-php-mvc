<?php

namespace App\Controller;

use App\Middleware\Guard;
use App\Routing\Attribute\Route;

class ParamsController extends AbstractController
{
    #[Route("/params", name: "param_page")]
    public function test()
    {
        echo "Page de test";
        if (isset($_REQUEST["guardLevel"])) {
            session_start();
            $this->container->get(Guard::class)->setSessionGuardLevel($_REQUEST["guardLevel"]);
            echo "<br>guardLevel set to " . $_REQUEST["guardLevel"] . "<br>";
        }
        echo "<br>guardLevel is currently " . ($_SESSION["guardLevel"] ?? "unset") . "<br>";
    }
}
