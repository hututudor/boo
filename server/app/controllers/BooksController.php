<?php

require_once ROOT_DIR . '/app/repositories/BookRepository.php';
require_once ROOT_DIR . '/app/services/books/BooksService.php';
require_once ROOT_DIR . '/app/validation.php';

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

  public function add(Request $request) {
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
    BookRepository::deleteById($request->params['id']);

    Response::success();
  }

  public function getReadingStatus(Request $request): void
  {
      $serviceResponse = BooksService::getReadingStatus($request->params['id'], Headers::getHeaderValue($request->headers, 'Authorization'));

      Response::custom($serviceResponse->getResponseStatus(), $serviceResponse->getResponseData());
  }

    public function updateReadingStatus(Request $request): void
    {
        if($this->validateReadingStatusBody($request)) {
            Response::badRequest($request->body);
            return;
        }

        $serviceResponse = BooksService::updateReadingStatus($request->params['id'], $request->body['status'], Headers::getHeaderValue($request->headers, 'Authorization'));

        Response::custom($serviceResponse->getResponseStatus(), $serviceResponse->getResponseData());
    }

    public function addReadingStatus(Request $request): void
    {
        if($this->validateReadingStatusBody($request)) {
            Response::badRequest($request->body);
            return;
        }

        $serviceResponse = BooksService::addReadingStatus($request->params['id'], $request->body['status'], Headers::getHeaderValue($request->headers, 'Authorization'));

        Response::custom($serviceResponse->getResponseStatus(), $serviceResponse->getResponseData());
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