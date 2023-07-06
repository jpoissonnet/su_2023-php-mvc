<?php

namespace App\Controller;

use App\DependencyInjection\Container;

abstract class AbstractController
{
    public function __construct(
        protected Container $container
    )
    {
    }
}
