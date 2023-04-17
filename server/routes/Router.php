<?php

enum RouteVerb {
  case GET;
  case POST;
  case PUT;
  case DELETE;
}

class Route {
  public RouteVerb $verb;
  public string $path;

  public $handler;
}

class Router {
  private $routes;

  public function __construct() {
    $this->routes = array();
  }

  public function get(string $path, $handler) {
    $route = new Route;
    $route->verb = RouteVerb::GET;
    $route->path = $path;
    $route->handler = $handler;

    array_push($this->routes, $route);
  }

  public function execute() {
    print_r($this->routes);
  }
}
