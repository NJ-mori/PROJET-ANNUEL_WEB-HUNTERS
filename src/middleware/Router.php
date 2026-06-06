<?php

class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        
        if (strpos($path, '?') !== false) {
            $path = substr($path, 0, strpos($path, '?'));
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                call_user_func($route['handler']);
                return;
            }
        }

        $this->error(404);
    }

    public function error($code) {
        http_response_code($code);
        include '../src/views/errors.php';
    }

    public function onlinecheck() {
        if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("UPDATE users SET last_activity = NOW() WHERE id_user = ?");
        $stmt->execute([$_SESSION['user_id']]);
    }
    }
}