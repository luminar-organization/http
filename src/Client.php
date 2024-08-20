<?php

namespace Luminar\Http;

use Luminar\Http\Exceptions\ClientException;

class Client
{
    /**
     * Base URL for requests
     *
     * @var string $baseUrl
     */
    protected string $baseUrl;

    /**
     * Default Headers for the requests
     *
     * @var array $defaultHeaders
     */
    protected array $defaultHeaders;

    /**
     * @param string $baseUrl
     * @param array $defaultHeaders
     */
    public function __construct(string $baseUrl = '', array $defaultHeaders = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultHeaders = $defaultHeaders;
    }

    /**
     * Send a GET request.
     *
     * @param string $uri
     * @param array $queryParams
     * @param array $headers
     * @return array
     * @throws ClientException
     */
    public function get(string $uri, array $queryParams = [], array $headers = []): array
    {
        $url = $this->buildUrl($uri, $queryParams);
        return $this->sendRequest('GET', $url, [], $headers);
    }

    /**
     * Send a POST request.
     *
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return array
     * @throws ClientException
     */
    public function post(string $uri, array $body = [], array $headers = []): array
    {
        $url = $this->buildUrl($uri);
        return $this->sendRequest('POST', $url, $body, $headers);
    }

    /**
     * Send a PUT request.
     *
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return array
     * @throws ClientException
     */
    public function put(string $uri, array $body = [], array $headers = []): array
    {
        $url = $this->buildUrl($uri);
        return $this->sendRequest('PUT', $url, $body, $headers);
    }

    /**
     * Send a DELETE request.
     *
     * @param string $uri
     * @param array $body
     * @param array $headers
     * @return array
     * @throws ClientException
     */
    public function delete(string $uri, array $body = [], array $headers = []): array
    {
        $url = $this->buildUrl($uri);
        return $this->sendRequest('DELETE', $url, $body, $headers);
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @return string
     */
    protected function buildUrl(string $uri, array $queryParams = []): string
    {
        $url = $this->baseUrl . '/' . ltrim($uri, '/');
        if(!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        return $url;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $body
     * @param array $headers
     * @param bool $decode
     * @return array
     * @throws ClientException
     */
    protected function sendRequest(string $method, string $url, array $body = [], array $headers = [], bool $decode = false): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $headers = array_merge($this->defaultHeaders, $headers);
        $formattedHeaders = [];
        foreach($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);

        if(!empty($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new ClientException("Client error: $error");
        }

        curl_close($ch);
        if($decode) {
            $response = json_decode($response, true);
        }

        return [
            'statusCode' => $statusCode,
            'body' => $response
        ];
    }
}