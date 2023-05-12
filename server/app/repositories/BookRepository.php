<?php

require_once ROOT_DIR . '/app/models/Book.php';

class BookRepository {
  public static function getAll(): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM books");
    $statement->execute();

    if($statement->error) {
      return [];
    }

    $books = [];
    foreach ($statement->get_result() as $row) {
      $books[] = self::toBook($row);
    }

    return $books;
  }

  public static function getById(string $id): ?Book {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM books WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $row = $statement->get_result()->fetch_assoc();
    if(!$row) {
      return null;
    }

    return self::toBook($row);
  }

  public static function insert(Book $book): ?Book {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("INSERT INTO books (title, image, author, book_description, pages, isbn, genre, publisher, format, publication_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param("sssss", $book->title, $book->image, $book->author, $book->book_description, $book->pages, $book->isbn, $book->genre, $book->publisher, $book->format, $book->publication_date);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $book->id = $statement->insert_id;
    return $book;
}

public static function update(Book $book): bool {
  $db = DB::getInstance()->getConnection();
  $statement = $db->prepare("UPDATE books SET title = ?, image = ?, author = ?, book_description = ?, pages = ?, isbn = ?, genre = ?, publisher = ?, format = ?, publication_date = ? WHERE id = ?");
  $statement->bind_param("sssss", $book->title, $book->image, $book->author, $book->book_description, $book->pages, $book->isbn, $book->genre, $book->publisher, $book->format, $book->publication_date, $book->id);
  $statement->execute();

  return !!$statement->error;
}

  public static function deleteById(string $id): void {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("DELETE FROM books WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
  }

  private static function toBook(array $row): Book {
    return new Book($row['id'], $row['title'], $row['image'], $row['author'], $row['pages'], $row['isbn'], $row['genre'], $row['publisher'], $row['format'], $row['publication_date']);
  }
}