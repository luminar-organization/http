<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Client;
use Luminar\Http\Exceptions\ClientException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private Client $client;
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new Client('https://example.com/');
    }

    /**
     * @return void
     * @throws ClientException
     */
    public function testRequest(): void
    {
        $response = $this->client->get("/");
        $this->assertNotNull($response);
    }

}