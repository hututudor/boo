<?php

require_once '../config/config.php';
require_once '../app/Router.php';
require_once '../app/DB.php';

require_once '../app/repositories/BookRepository.php';

$router = new Router();

require_once '../routes/index.php';

$router->handle();