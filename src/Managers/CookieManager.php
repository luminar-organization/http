<?php

namespace Luminar\Http\Managers;

class CookieManager
{
    /**
     * @var bool $debug
     */
    protected bool $debug;

    /**
     * @var array $cookiesDebug
     */
    private array $cookiesDebug;

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * Set a cookie.
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return void
     */
    public function set(
        string $name,
        string $value,
        int $expire = 0,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httponly = true
    ): void {
        if(!$this->isDebug()) {
            setcookie($name, $value, [
                'expires' => $expire,
                'path' => $path,
                'domain' => $domain,
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => 'Lax' // Adding SameSite for CSRF protection
            ]);
            return;
        }
        $this->cookiesDebug[$name] = $value;
    }

    /**
     * Get a cookie by name.
     *
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        if(!$this->isDebug()) {
            return $_COOKIE[$name] ?? $default;
        }
        return $this->cookiesDebug[$name] ?? $default;
    }

    /**
     * Delete a cookie.
     *
     * @param string $name
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httponly
     * @return void
     */
    public function delete(
        string $name,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httponly = true
    ): void {
        if(!$this->isDebug()) {
            setcookie($name, '', time() - 3600, $path, $domain, $secure, $httponly);
            unset($_COOKIE[$name]);
            return;
        }
        unset($this->cookiesDebug[$name]);
    }

    /**
     * Check if a cookie exists.
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        if(!$this->isDebug()) {
            return isset($_COOKIE[$name]);
        }
        return isset($this->cookiesDebug[$name]);
    }
}