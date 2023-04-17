<?php

require_once 'Router.php';

$router = new Router();

$router->get('/', function () {});
$router->get('/users', function () {});
$router->get('/users/:id', function () {});

$router->execute();