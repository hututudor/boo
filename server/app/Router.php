<?php

enum RouteMethod: string {
  case GET = 'GET';
  case POST = 'POST';
  case PUT = 'PUT';
  case DELETE = 'DELETE';
}

class Request {
  public array $params;
  public array $body;
  public array $query;
}

class Response {
  public static function success($data = null): void {
    if($data) {
      echo json_encode($data);
    }
  }

  public static function notFound($data = null): void {
    header("HTTP/1.0 404 Not Found");
    if($data) {
      echo json_encode($data);
    }
  }

  public static function unauthorized($data = null): void {
    header("HTTP/1.0 401 Unauthorized");
    if($data) {
      echo json_encode($data);
    }
  }

  public static function badRequest($data = null): void {
    header("HTTP/1.0 400 Bad Request");
    if($data) {
      echo json_encode($data);
    }
  }

  public static function internalServerError($data = null): void {
    header("HTTP/1.0 500 Internal Server Error");
    if($data) {
      echo json_encode($data);
    }
  }
}

class Route {
  public RouteMethod $method;
  public string $path;
  public array $handler;
}

class Router {
  private array $routes;

  public function __construct() {
    $this->routes = array();
  }

  public function get(string $path, string $handler): void {
    $this->addRoute($path, $handler, RouteMethod::GET);
  }

  public function post(string $path, string $handler): void {
    $this->addRoute($path, $handler, RouteMethod::POST);
  }

  public function put(string $path, string $handler): void {
    $this->addRoute($path, $handler, RouteMethod::PUT);
  }

  public function delete(string $path, string $handler): void {
    $this->addRoute($path, $handler, RouteMethod::DELETE);
  }

  private function addRoute(string $path, string $handler, RouteMethod $method): void {
    $route = new Route;
    $route->method = $method;
    $route->path = $path;
    $route->handler = explode('@', $handler);

    $this->routes[] = $route;
  }

  public function handle(): void {
    $method = $_SERVER["REQUEST_METHOD"];

    $possibleRoutesByMethod = array_filter($this->routes, function($route) use($method) {
      return $route->method->value == $method;
    });

    foreach ($possibleRoutesByMethod as $route) {
      $routePath = $this->explodePath($route->path);
      $currentPath = $this->explodePath('/' . $_GET["route"]);

      if(count($routePath) != count($currentPath)) {
        continue;
      }

      if(!$this->match($routePath, $currentPath)) {
        continue;
      }

      $request = new Request;
      $request->params = $this->parseParams($routePath, $currentPath);
      $request->query = $_GET;
      $request->body = $this->parseBody();

      // route matches, call the handler
      require_once 'controllers/' . $route->handler[0] . '.php';
      $callback = new $route->handler[0];
      $callback->{$route->handler[1]}($request);

      return;
    }

    Response::notFound();
  }

  private function explodePath($path): array {
    return array_values(array_filter(explode('/', $path), function ($seg) { return !!$seg; }));
  }

  private function match(array $source, array $current): bool {
    for($i = 0; $i < count($source); $i++) {
      if(!(str_starts_with($source[$i], ":") && !!$current) && $source[$i] != $current[$i]) {
        return false;
      }
    }

    return true;
  }

  private function parseParams(array $source, array $current): array {
    $params = [];

    for($i = 0; $i < count($source); $i++) {
      if(!str_starts_with($source[$i], ":")) {
        continue;
      }

      $params[explode(':', $source[$i])[1]] = $current[$i];
    }

    return $params;
  }

  private function parseBody() {
    if(count($_POST)) {
      return $_POST;
    }

    $body = json_decode(file_get_contents('php://input'), true);
    if($body) {
      return $body;
    }

    return [];
  }
}