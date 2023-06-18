<?php

global $router;

$router->get('/api/books/:book_id/reviews', 'ReviewsController@getByBookId');
$router->get('/api/reviews', 'ReviewsController@getByUserId');
$router->post('/api/books/:book_id/reviews', 'ReviewsController@add');
$router->delete('/api/reviews/:id', 'ReviewsController@delete');

$router->get('/api/books', 'BooksController@list');
$router->get('/api/books/:id/recommendations', 'BooksController@listRecommendations');
$router->get('/api/books/:id', 'BooksController@get');
$router->post('/api/books', 'BooksController@add');
$router->put('/api/books/:id', 'BooksController@update');
$router->delete('/api/books/:id', 'BooksController@delete');
$router->get('/api/books/:id/readingStatus', 'BooksController@getReadingStatus');
$router->put('/api/books/:id/readingStatus', 'BooksController@updateReadingStatus');

$router->get('/api/books/search/:query', 'BooksController@search');
$router->get('/api/books/category/:query', 'BooksController@getByCategory');
$router->get('/api/books/author/:query', 'BooksController@getByAuthor');


$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/register', 'AuthController@register');

$router->get('/login', 'ViewController@login');
$router->get('/register', 'ViewController@register');
$router->get('/', 'ViewController@books');
$router->get('/books', 'ViewController@books');
$router->get('/books/:id', 'ViewController@book');
$router->get('/reviews', 'ViewController@reviews');
$router->get('/about', 'ViewController@about');
$router->get('/help', 'ViewController@help');
$router->get('/manager', 'ViewController@manager');
$router->get('/manager/add', 'ViewController@managerAdd');
$router->get('/manager/:id', 'ViewController@managerEdit');

$router->get('/api/home/analytics', 'HomeController@getAnalytics');
