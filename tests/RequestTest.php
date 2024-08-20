<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGetClientIp(): void
    {
        $request = new Request([], [], [], 'GET', '/', ['REMOTE_ADDR' => '127.0.0.1']);
        $this->assertEquals('127.0.0.1', $request->getClientIp());
    }

    public function testGetAuthorizationHeader(): void
    {
        $request = new Request([], [], ['Authorization' => 'Bearer token']);
        $this->assertEquals('Bearer token', $request->getAuthorizationHeader());
    }

    public function testGetBearerToken(): void
    {
        $request = new Request([], [], ['Authorization' => 'Bearer token']);
        $this->assertEquals('token', $request->getBearerToken());
    }

    public function getUserAgent(): void
    {
        $request = new Request([], [], ['User-Agent' => 'Mozilla/5.0']);
        $this->assertEquals('Mozilla/5.0', $request->getUserAgent());
    }

}