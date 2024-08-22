<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Controller\AbstractController;
use Luminar\Http\Response;

class ExampleController extends AbstractController
{
    public function index(): Response
    {
        return $this->render("example", ['name' => 'Luminar']);
    }
}