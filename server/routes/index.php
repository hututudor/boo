<?php

global $router;

$router->get('/api/docbook', 'DocBookController@getDocBookDocument');

$router->get('/api/csv', 'CsvController@getCsv');

$router->get('/api/rss/:user_id', 'RssController@getFeed');

$router->get('/api/books/:book_id/reviews', 'ReviewsController@getByBookId');
$router->get('/api/reviews', 'ReviewsController@getByUserId');
$router->post('/api/books/:book_id/reviews', 'ReviewsController@add');
$router->delete('/api/reviews/:id', 'ReviewsController@delete');

$router->get('/api/books/search', 'BooksController@search');
$router->get('/api/books/category', 'BooksController@getByCategory');
$router->get('/api/books/author', 'BooksController@getByAuthor');

$router->get('/api/books', 'BooksController@list');
$router->get('/api/books/:id/recommendations', 'BooksController@listRecommendations');
$router->get('/api/books/:id', 'BooksController@get');
$router->post('/api/books', 'BooksController@add');
$router->put('/api/books/:id', 'BooksController@update');
$router->delete('/api/books/:id', 'BooksController@delete');
$router->get('/api/books/:id/readingStatus', 'BooksController@getReadingStatus');
$router->put('/api/books/:id/readingStatus', 'BooksController@updateReadingStatus');

$router->get('/api/questions/:id', 'ReplyController@getAll');
$router->post('/api/questions/:id', 'ReplyController@add');
$router->delete('/api/replies/:id', 'ReplyController@delete');

$router->get('/api/questions', 'QuestionsController@getAll');
$router->post('/api/questions', 'QuestionsController@add');
$router->delete('/api/questions/:id', 'QuestionsController@delete');

$router->put('/api/profile/email', 'UserController@updateEmail');
$router->put('/api/profile/name', 'UserController@updateName');
$router->put('/api/profile/password', 'UserController@updatePassword');
$router->get('/api/profile', 'UserController@getProfile');

$router->post('/api/auth/login', 'AuthController@login');
$router->post('/api/auth/register', 'AuthController@register');

$router->get('/api/users', 'AdminController@getAllUsers');
$router->put('/api/users/:id/promote', 'AdminController@promote');
$router->put('/api/users/:id/demote', 'AdminController@demote');
$router->delete('/api/users/:id', 'AdminController@delete');

$router->get('/login', 'ViewController@login');
$router->get('/register', 'ViewController@register');
$router->get('/home', 'ViewController@home');
$router->get('/profile', 'ViewController@profile');
$router->get('/', 'ViewController@books');
$router->get('/books', 'ViewController@books');
$router->get('/books/search', 'ViewController@search');
$router->get('/books/genre', 'ViewController@genre');
$router->get('/books/author', 'ViewController@author');
$router->get('/books/:id', 'ViewController@book');
$router->get('/reviews', 'ViewController@reviews');
$router->get('/about', 'ViewController@about');
$router->get('/help', 'ViewController@help');
$router->get('/help/:id', 'ViewController@helpQuestion');
$router->get('/manager/users', 'ViewController@usersManager');
$router->get('/manager', 'ViewController@manager');
$router->get('/manager/add', 'ViewController@managerAdd');
$router->get('/manager/:id', 'ViewController@managerEdit');

$router->get('/api/home/analytics', 'HomeController@getAnalytics');
$router->get('/api/home/books', 'HomeController@getBooks');
