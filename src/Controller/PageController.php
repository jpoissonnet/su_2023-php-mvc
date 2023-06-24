<?php

namespace App\Controller;

class PageController
{
    public function response()
    {
        include("pages/".strtok($_SERVER["REQUEST_URI"], '?'). '.php');
    }
}
