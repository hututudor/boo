<?php

require_once ROOT_DIR . '/app/repositories/BookRepository.php';
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
    $book->book_description = $request->body['book_description'];
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
    $book->book_description = $request->body['book_description'];
    $book->isbn = $request->body['isbn'];
    $book->genre = $request->body['genre'];
    $book->publisher = $request->body['publisher'];
    $book->format = $request->body['format'];
    $book->publication_date = $request->body['publication_date'];

    $updated = BookRepository::update($book);

    if(!$updated) {
      Response::notFound();
    }

    Response::success(BookRepository::getById($book->id));
  }

  public function delete(Request $request): void {
    BookRepository::deleteById($request->params['id']);

    Response::success();
  }

  private function validateBookBody(Request $request): ?array {
    return validate($request->body, [
      'pages' => ['required', 'integer'],
    'title' => ['required'],
    'author' => ['required'],
    'image' => ['required'],
    'book_description' => ['required'],
    'isbn' => ['required'],
    'genre' => ['required'],
    'publisher' => ['required'],
    'format' => ['required'],
    'publication_date' => ['required','date']
    ]);
  }
}