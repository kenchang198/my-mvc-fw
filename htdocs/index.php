<?php

require __DIR__ . '/../app/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'top');
    $r->addRoute('GET', '/login/', 'login');

    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'user');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        if (!empty($vars)) {
            // ... call $handler with $vars
            echo $handler($vars);
        } else {
            echo $handler();
        }

        break;
}

function top()
{
    return '<html><h1>top page</h1></html>';
}

function login()
{
    return '<html><h1>login page</h1></html>';
}

function user(array $args)
{
    $id = $args['id'];
    return "<html><h1>user id: $id</h1></html>";
}
