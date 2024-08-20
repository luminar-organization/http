<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Managers\CookieManager;
use PHPUnit\Framework\TestCase;

/**
 * WARNING!
 * These tests are not very accuracy because while testing we don't have access to "real cookies functions like setcookie"
 * so we need to emulate them by array $cookiesDebug in CookieManager and enabling debugMode by setDebug(true)
 */
class CookieManagerTest extends TestCase
{
    protected CookieManager $cookieManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->cookieManager = new CookieManager();
        $this->cookieManager->setDebug(true);
    }

    public function testSetAndGetCookie()
    {
        $this->cookieManager->set('test_cookie', 'test_value');
        $this->assertEquals('test_value', $this->cookieManager->get('test_cookie'));
    }

    public function testDeleteCookie()
    {
        $this->cookieManager->set('test_cookie', 'test_value');
        $this->cookieManager->delete('test_cookie');
        $this->assertNull($this->cookieManager->get('test_cookie'));
    }

    public function testHasCookie()
    {
        $this->cookieManager->set('test_cookie', 'test_value');
        $this->assertTrue($this->cookieManager->has('test_cookie'));

        $this->cookieManager->delete('test_cookie');
        $this->assertFalse($this->cookieManager->has('test_cookie'));
    }
}