<?php

global $router;

$router->get('/books', 'BooksController@list');
$router->get('/books/:id', 'BooksController@get');
$router->post('/books', 'BooksController@add');
$router->put('/books/:id', 'BooksController@update');
$router->delete('/books/:id', 'BooksController@delete');

$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/register', 'AuthController@register');

$router->get('/books/:bookId/reviews', 'ReviewsController@getByBookId');
$router->get('/reviews', 'ReviewsController@getByUserId');
$router->post('/books/:bookdId/reviews', 'ReviewsController@add');
$router->delete('/reviews/:reviewId', 'ReviewsController@delete');