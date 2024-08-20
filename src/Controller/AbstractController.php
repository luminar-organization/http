<?php

namespace Luminar\Http\Controller;

use Luminar\Http\Response;
use Luminar\RenderEngine\View;

class AbstractController
{
    /**
     * @var View $view
     */
    protected View $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param string $key
     * @param $default
     * @return mixed|null
     */
    protected function input(string $key, $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }

    /**
     * @param string $url
     * @param int $status
     * @return Response
     */
    protected function redirect(string $url, int $status = 302): Response
    {
        $response = new Response("", $status, $this);
        $response->setHeader('Location', $url);
        return $response;
    }

    /**
     * @param string $view
     * @param array $data
     * @return Response
     */
    protected function render(string $view, array $data = []): Response
    {
        return $this->view->render($view, $data);
    }

    /**
     * @param array $response
     * @param int $status
     * @return Response
     */
    protected function json(array $response, int $status = 200): Response
    {
        $response = new Response(json_encode($response), $status, $this);
        $response->setHeader('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param string $text
     * @param int $status
     * @return Response
     */
    protected function text(string $text, int $status = 200): Response
    {
        return new Response($text, $status, $this);
    }
}