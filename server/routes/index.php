<?php

global $router;

$router->get('/books', 'BooksController@list');
$router->get('/books/:id', 'BooksController@get');
$router->post('/books', 'BooksController@add');
$router->put('/books/:id', 'BooksController@update');
$router->delete('/books/:id', 'BooksController@delete');

$router->post('/auth', 'AuthController@login');
//$router->post('/auth/register', 'AuthController@register');