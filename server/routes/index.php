<?php

global $router;

$router->get('/api/books', 'BooksController@list');
$router->get('/api/books/:id', 'BooksController@get');
$router->post('/api/books', 'BooksController@add');
$router->put('/api/books/:id', 'BooksController@update');
$router->delete('/api/books/:id', 'BooksController@delete');

$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/register', 'AuthController@register');

$router->get('/login', 'ViewController@login');
$router->get('/register', 'ViewController@register');
$router->get('/', 'ViewController@books');
$router->get('/books', 'ViewController@books');
$router->get('/books/:id', 'ViewController@book');
$router->get('/about', 'ViewController@about');
$router->get('/help', 'ViewController@help');
