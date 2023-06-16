<?php

require_once '../config/config.php';
require_once '../app/Router.php';
require_once '../app/DB.php';

require_once '../app/repositories/BookRepository.php';
require_once '../app/repositories/UserRepository.php';

// enable cors
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  return 0;
}

$router = new Router();

require_once '../routes/index.php';

$router->handle();
