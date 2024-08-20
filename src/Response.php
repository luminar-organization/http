<?php

namespace Luminar\Http;

use Luminar\Http\Controller\AbstractController;

class Response
{
    private array $headers;
    private string $response;
    private int $status;
    private AbstractController $controller;
    public function __construct(string $response, int $status,AbstractController $controller)
    {
        $this->response = $response;
        $this->status = $status;
        $this->controller = $controller;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return AbstractController
     */
    public function getController(): AbstractController
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getHeader(string $key, mixed $default = null): mixed
    {
        return $this->headers[$key] ?? $default;
    }
}