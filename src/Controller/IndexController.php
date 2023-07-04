<?php

namespace App\Controller;

use App\Routing\Attribute\Route;
use Twig\Environment;

class IndexController extends AbstractController
{

  #[Route("/", name: "homepage")]
  public function home()
  {
    echo $this->container->get(Environment::class)->render('index.html.twig');
  }
}
