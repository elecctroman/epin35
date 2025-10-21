<?php
namespace Core;

class Router
{
    private array $routes = [];
    private array $middlewareGroups = [];

    public function group(array $options, callable $callback): void
    {
        $this->middlewareGroups[] = $options['middleware'] ?? [];
        $callback($this);
        array_pop($this->middlewareGroups);
    }

    public function add(string $method, string $uri, callable $action, array $middleware = []): void
    {
        $method = strtoupper($method);
        $pattern = $this->compileRoute($uri);
        $groupMiddleware = [];
        foreach ($this->middlewareGroups as $group) {
            $groupMiddleware = array_merge($groupMiddleware, $group);
        }
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'action' => $action,
            'middleware' => array_merge($groupMiddleware, $middleware)
        ];
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $this->normalize(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route) {
            if (preg_match($route['pattern']['regex'], $path, $matches)) {
                $params = [];
                foreach ($route['pattern']['parameters'] as $name => $index) {
                    $params[$name] = $matches[$index] ?? null;
                }
                $request = [
                    'get' => $_GET,
                    'post' => $_POST,
                    'body' => file_get_contents('php://input'),
                    'session' => Helpers::session(),
                    'params' => $params,
                ];
                $action = $route['action'];
                $middlewareStack = $this->buildMiddlewareStack($route['middleware'], $action, $params);
                $middlewareStack($request);
                return;
            }
        }

        http_response_code(404);
        echo View::render('errors/404', []);
    }

    private function buildMiddlewareStack(array $middleware, callable $last, array $params): callable
    {
        $next = function ($request) use ($last, $params) {
            return $last($request, $params);
        };
        foreach (array_reverse($middleware) as $layer) {
            $next = function ($request) use ($layer, $next) {
                return $layer($request, $next);
            };
        }
        return $next;
    }

    private function compileRoute(string $uri): array
    {
        $uri = $this->normalize($uri);
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', '(?P<$1>[^/]+)', $uri);
        $regex = '#^' . $pattern . '$#';
        preg_match_all('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', $uri, $paramMatches);
        $parameters = [];
        $index = 1;
        foreach ($paramMatches[1] as $name) {
            $parameters[$name] = $index++;
        }
        return ['regex' => $regex, 'parameters' => $parameters];
    }

    private function normalize(string $uri): string
    {
        $uri = '/' . trim($uri, '/');
        return $uri === '/' ? $uri : rtrim($uri, '/');
    }
}
