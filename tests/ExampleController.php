<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Controller\AbstractController;

class ExampleController extends AbstractController
{
    public function index()
    {
        return $this->render("example", ['name' => 'Luminar']);
    }
}