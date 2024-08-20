# Luminar HTTP
The Luminar HTTP package provides a robust set of tools for handling HTTP requests and responses in PHP. It Includes classes for managing requests, sessions, cookies, and middleware.

## Installation
You can install Luminar HTTP via Composer
```shell
composer require luminar-organization/http
```

## Usage
- Request Handling
```php
use Luminar\Http\Request;

$request = new Request($queryParams, $bodyParams, $headers, $method, $uri, $serverParams);
$clientIp = $request->getClientIp();
$authHeader = $request->getAuthorizationHeader();
$bearerToken = $request->getBearerToken();
$userAgent = $request->getUserAgent();
```
- Session Management
```php
use Luminar\Http\Session\SessionManager;

$session = new SessionManager();
$session->set('key', 'value');
$value = $session->get('key');
$session->destroy();
```
- Cookie Management
```php
use Luminar\Http\Cookie\CookieManager;

$cookieManager = new CookieManager();
$cookieManager->set('name', 'value');
$cookieValue = $cookieManager->get('name');
$cookieManager->delete('name');
```
- Middleware
```php
use Luminar\Http\Middleware\MiddlewareInterface;
use Luminar\Http\Response;

class ExampleMiddleware implements MiddlewareInterface
{
    public function run(Request $request): Response|null
    {
        // Do some your staff for e.g. analytics
        return null; // return null if you don't want to stop request
    }
}
```
- Abstract Controller (Works with our [Render Engine](https://github.com/luminar-organization/render-engine))
```php
use Luminar\Http\Controller\AbstractController;
use Luminar\Http\Response;

class HomeController extends AbstractController
{
    public function jsonRequest(): Response
    {
        return $this->json([
            'Hello' => 'World!'
        ]);
    }
    
    public function textRequest(): Response
    {
        return $this->text("Hello World!");
    }
    
    public function index()
    {
        return $this->render('home/index');
    }
}

```