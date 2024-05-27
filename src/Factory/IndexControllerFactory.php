<?php

namespace Desafio\Picpay\Factory;

use Desafio\Picpay\Controllers\Controller;

trait IndexControllerFactory
{
    public function createIndexController(): Controller
    {
        return new Controller;
    }
}