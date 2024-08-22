<?php

namespace Luminar\Http\Managers;

use Luminar\Http\Exceptions\SessionException;

class SessionManager
{
    public function __construct()
    {
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if a session has already been started
     *
     * @return bool
     */
    public function isStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Regenerate the session ID
     *
     * @param bool $deleteOldSession
     * @return void
     */
    public function regenerate(bool $deleteOldSession = true): void
    {
        if($this->isStarted()) {
            session_regenerate_id($deleteOldSession);
        }
    }

    /**
     * Set a value in the session
     *
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws SessionException
     */
    public function set(string $key, mixed $value): void
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        $_SESSION[$key] = $value;
    }

    /**
     * Gets a value from the session
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws SessionException
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Checks if a key exists in the session
     *
     * @param string $key
     * @return bool
     * @throws SessionException
     */
    public function has(string $key): bool
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        return isset($_SERVER[$key]);
    }

    /**
     * Removes a value from the session
     *
     * @param string $key
     * @return void
     * @throws SessionException
     */
    public function remove(string $key): void
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        unset($_SESSION[$key]);
    }

    /**
     * Destroys the session
     *
     * @return void
     */
    public function destroy(): void
    {
        if($this->isStarted()) {
            session_unset();
            session_destroy();
        }
    }

    /**
     * Gets the session id
     *
     * @return string|bool
     */
    public function getId(): string|bool
    {
        return session_id();
    }

    /**
     * Sets the session id
     *
     * @param string $id
     * @return void
     * @throws SessionException
     */
    public function setId(string $id): void
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        session_id($id);
    }

    /**
     * Sets the session name
     *
     * @param string $name
     * @return void
     * @throws SessionException
     */
    public function setName(string $name): void
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        session_name($name);
    }

    /**
     * Gets the session name
     *
     * @return string|bool
     * @throws SessionException
     */
    public function getName(): string|bool
    {
        if(!$this->isStarted()) {
            throw new SessionException("Session is not started yet");
        }
        return session_name();
    }
}