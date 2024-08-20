<?php

namespace Luminar\Http\Tests;

use Luminar\Http\Exceptions\SessionException;
use Luminar\Http\Managers\SessionManager;
use PHPUnit\Framework\TestCase;

class SessionManagerTest extends TestCase
{
    /**
     * @return void
     */
    public function testSessionStart(): void
    {
        $session = new SessionManager();
        $this->assertTrue($session->isStarted());
    }

    /**
     * @return void
     * @throws SessionException
     */
    public function testSetAndGet(): void
    {
        $session = new SessionManager();
        $session->set('test_key', 'test_value');
        $this->assertEquals('test_value', $session->get('test_key'));
    }

    /**
     * @return void
     * @throws SessionException
     */
    public function testRemove(): void
    {
        $session = new SessionManager();
        $session->set('test_key', 'test_value');
        $session->remove('test_key');
        $this->assertNull($session->get('test_key'));
    }

    /**
     * @return void
     * @throws SessionException
     */
    public function testDestroy()
    {
        $session = new SessionManager();
        $this->expectException(SessionException::class);
        $this->expectExceptionMessage("Session is not started yet");
        $session->set('test_key', 'test_value');
        $session->destroy();
        $this->assertFalse($session->isStarted());
        $this->assertNull($session->get('test_key'));
    }
}