<?php

namespace Luminar\Http\Tests;

use Luminar\RenderEngine\Engine\TwigEngine;
use Luminar\RenderEngine\View;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testAbstract(): void
    {
        $controller = new ExampleController(new View(new TwigEngine(__DIR__ . DIRECTORY_SEPARATOR . 'templates')));
        $result = $controller->index();
        $this->assertStringContainsString('Hello, Luminar', $result->getResponse());
    }
}