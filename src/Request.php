<?php

namespace Luminar\Http;

class Request
{
    /**
     * @var array $queryParams
     */
    protected array $queryParams;

    /**
     * @var array $bodyParams
     */
    protected array $bodyParams;

    /**
     * @var array $headers
     */
    protected array $headers;

    /**
     * @var string $method
     */
    protected string $method;

    /**
     * @var string $uri
     */
    protected string $uri;

    /**
     * @var array $serverParams
     */
    protected array $serverParams;

    /**
     * @param array $queryParams
     * @param array $bodyParams
     * @param array $headers
     * @param string $method
     * @param string $uri
     * @param array $serverParams
     */
    public function __construct(array $queryParams = [], array $bodyParams = [], array $headers = [], string $method = 'GET', string $uri = '/', array $serverParams = [])
    {
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
        $this->headers = $headers;
        $this->method = $method;
        $this->uri = $uri;
        $this->serverParams = $serverParams;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getQueryParam(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function getBodyParams(): array
    {
        return $this->bodyParams;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function getBodyParam(string $key, mixed $default = null): mixed
    {
        return $this->bodyParams[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
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

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method): bool
    {
        return strtoupper($this->method) === strtoupper($method);
    }

    /**
     * @return array
     */
    public function parseJsonBody(): array
    {
        return json_decode($this->getBody(), true) ?? [];
    }

    /**
     * @return string
     */
    private function getBody(): string
    {
        return file_get_contents('php://input');
    }

    /**
     * @return string|null
     */
    public function getClientIp(): ?string
    {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($keys as $key) {
            if(array_key_exists($key, $this->serverParams)) {
                $ip = trim($this->serverParams[$key]);
                if(filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getAuthorizationHeader(): ?string
    {
        return $this->getHeader('Authorization');
    }

    /**
     * @return string|null
     */
    public function getBearerToken(): ?string
    {
        $authorization = $this->getAuthorizationHeader();
        if($authorization && preg_match("/Bearer\s(\S+)/", $authorization, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->getHeader('User-Agent');
    }
}