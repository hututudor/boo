<?php

require_once ROOT_DIR . '/app/repositories/BookRepository.php';
require_once ROOT_DIR . '/app/services/books/ReadingStatusService.php';
require_once ROOT_DIR . '/app/validation.php';
require_once __DIR__ . '/../services/utils/JwtUtils.php';
require_once __DIR__ . '/../services/utils/AuthorizationUtils.php';

class BooksController {
  public function get(Request $request): void {
    $book = BookRepository::getById($request->params['id']);

    if(!$book) {
      Response::notFound();
      return;
    }

    Response::success($book);
  }

  public function list(Request $request): void {
    Response::success(BookRepository::getAll());
  }

  public function listRecommendations(Request $request): void {
    $book = BookRepository::getById($request->params['id']);
    if(!$book) {
      Response::notFound();
      return;
    }

    $books = BookRepository::getRelated($book);

    Response::success($books);
  }

  public function add(Request $request) {
    $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_admin_authorized) {
      Response::unauthorized();
      return;
    }

    $bodyErrors = $this->validateBookBody($request);
    if($bodyErrors) {
      Response::badRequest($bodyErrors);
      return;
    }

    $book = new Book();

    $book->pages = $request->body['pages'];
    $book->title = $request->body['title'];
    $book->image = $request->body['image'];
    $book->author = $request->body['author'];
    $book->description = $request->body['description'];
    $book->isbn = $request->body['isbn'];
    $book->genre = $request->body['genre'];
    $book->publisher = $request->body['publisher'];
    $book->format = $request->body['format'];
    $book->publication_date = $request->body['publication_date'];

    $inserted = BookRepository::insert($book);

    if(!$inserted) {
      Response::badRequest();
      return;
    }

    Response::success($inserted);
  }

  public function update(Request $request): void {
    $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_admin_authorized) {
      Response::unauthorized();
      return;
    }

    $bodyErrors = $this->validateBookBody($request);
    if($bodyErrors) {
      Response::badRequest($bodyErrors);
      return;
    }

    $book = new Book();
    $book->pages = $request->body['pages'];
    $book->title = $request->body['title'];
    $book->image = $request->body['image'];
    $book->author = $request->body['author'];
    $book->id = $request->params['id'];
    $book->description = $request->body['description'];
    $book->isbn = $request->body['isbn'];
    $book->genre = $request->body['genre'];
    $book->publisher = $request->body['publisher'];
    $book->format = $request->body['format'];
    $book->publication_date = $request->body['publication_date'];

    $updated = BookRepository::update($book);

    if(!$updated) {
      Response::notFound();
      return;
    }

    Response::success(BookRepository::getById($book->id));
  }

  public function delete(Request $request): void {
    $is_admin_authorized = AuthorizationUtils::isAdminAuthorized(Headers::getHeaderValue($request->headers, 'Authorization'));
    if (!$is_admin_authorized) {
      Response::unauthorized();
      return;
    }

    BookRepository::deleteById($request->params['id']);

    Response::success();
  }

  public function getReadingStatus(Request $request): void
  {
      $serviceResponse = ReadingStatusService::getReadingStatus($request->params['id'], Headers::getHeaderValue($request->headers, 'Authorization'));

      Response::custom($serviceResponse->getResponseStatus(), $serviceResponse->getResponseData());
  }

  public function updateReadingStatus(Request $request): void
  {
      try {

          if ($this->validateReadingStatusBody($request)) {
              Response::badRequest($request->body);
              return;
          }

          $serviceResponse = ReadingStatusService::updateReadingStatus($request->params['id'], $request->body['status'], Headers::getHeaderValue($request->headers, 'Authorization'));

          if($serviceResponse->getResponseStatus() == 'HTTP/1.0 200 Ok' || $serviceResponse->getResponseStatus() == 'HTTP/1.0 201 Created'){
              Response::success();
              return;
          }
          else
                Response::custom($serviceResponse->getResponseStatus(), $serviceResponse->getResponseData());
      }catch (Exception $e){
          Response::internalServerError('Error updating reading status');
      }
  }

  private function validateReadingStatusBody(Request $request): ?array {
    return validate($request->body, [
        'status' => ['required']
    ]);
  }
  private function validateBookBody(Request $request): ?array {
    return validate($request->body, [
      'pages' => ['required', 'number'],
      'title' => ['required'],
      'author' => ['required'],
      'image' => ['required'],
      'description' => ['required'],
      'isbn' => ['required'],
      'genre' => ['required'],
      'publisher' => ['required'],
      'format' => ['required'],
      'publication_date' => ['required','date']
    ]);
  }
}