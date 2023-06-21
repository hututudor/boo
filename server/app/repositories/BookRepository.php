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

  public static function getAllAboveFromId(string $id) : array
  {
      $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM books WHERE id > ?");
        $statement->bind_param("i", $id);
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

  public static function getRelated(Book $book): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM books where id != ? and genre = ? limit 4");
    $statement->bind_param("is", $book->id, $book->genre);
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

  public static function insert(Book $book): ?Book {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("INSERT INTO books (title, image, author, description, pages, isbn, genre, publisher, format, publication_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->bind_param("ssssisssss", $book->title, $book->image, $book->author, $book->description, $book->pages, $book->isbn, $book->genre, $book->publisher, $book->format, $book->publication_date);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $book->id = $statement->insert_id;
    return $book;
}

public static function update(Book $book): bool {
  $db = DB::getInstance()->getConnection();
  $statement = $db->prepare("UPDATE books SET title = ?, image = ?, author = ?, description = ?, pages = ?, isbn = ?, genre = ?, publisher = ?, format = ?, publication_date = ? WHERE id = ?");
  $statement->bind_param("ssssisssssi", $book->title, $book->image, $book->author, $book->description, $book->pages, $book->isbn, $book->genre, $book->publisher, $book->format, $book->publication_date, $book->id);
  $statement->execute();

  return !$statement->error;
}

  public static function deleteById(string $id): void {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("DELETE FROM books WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
  }

  public static function getReadingStatus(string $bookId, string $userId) : ?string {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM user_books WHERE book_id = ? AND user_id = ?");
    $statement->bind_param("ss", $bookId, $userId);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $row = $statement->get_result()->fetch_assoc();
    if(!$row) {
      return null;
    }

    return $row['status'];
  }

  public static function updateReadingStatus(string $bookId, string $userId, string $status): bool {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("UPDATE user_books SET status = ? WHERE book_id = ? AND user_id = ?");
    $statement->bind_param("sss",$status,$bookId, $userId);
    $statement->execute();

    return !$statement->error;
  }

  public static function insertReadingStatus(string $bookId, string $userId, string $status): bool {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("INSERT INTO user_books (book_id, user_id, status) VALUES (?, ?, ?)");
    $statement->bind_param("iis", $bookId, $userId, $status);
    $statement->execute();

    return !$statement->error;
  }


  public static function countStatus(string $userId, string $readingStatus) : int
  {
      $db = DB::getInstance()->getConnection();
      $statement = $db->prepare("SELECT COUNT(*) AS counter FROM user_books WHERE user_id = ? AND status = ?");
      $statement->bind_param("is", $userId, $readingStatus);
      $statement->execute();

      if ($statement->error) {
          return 0;
      }

      $row = $statement->get_result()->fetch_assoc();
      if (!$row) {
          return 0;
      }

      return $row['counter'];
  }
  public static function deleteReadingStatus(string $bookId, string $userId) : bool
  {
      $db = DB::getInstance()->getConnection();
      $statement = $db->prepare("DELETE FROM user_books WHERE book_id = ? AND user_id = ?");
      $statement->bind_param("ii", $bookId, $userId);
      $statement->execute();

      return !$statement->error;
  }

  public static function searchBooks($query) {
    $db = DB::getInstance()->getConnection();
    $searchTerm = '%' . $query . '%';
    $statement = $db->prepare("SELECT * FROM books WHERE lower(title) LIKE lower(?) OR lower(description) LIKE lower(?) OR lower(author) LIKE lower(?)");
    $statement->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $statement->execute();
  
    if ($statement->error) {
      return [];
    }
  
    $books = [];
    foreach ($statement->get_result() as $row) {
      $books[] = self::toBook($row);
    }
  
    return $books;
  }
  
  public static function getByCategory($category) {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM books WHERE lower(genre) = lower(?)");
    $statement->bind_param("s", $category);
    $statement->execute();
  
    if ($statement->error) {
      return [];
    }
  
    $books = [];
    foreach ($statement->get_result() as $row) {
      $books[] = self::toBook($row);
    }
  
    return $books;
  }
  
  public static function getByAuthor($author) {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM books WHERE lower(author) = lower(?)");
    $statement->bind_param("s", $author);
    $statement->execute();
  
    if ($statement->error) {
      return [];
    }
  
    $books = [];
    foreach ($statement->get_result() as $row) {
      $books[] = self::toBook($row);
    }
  
    return $books;
  }

  private static function toBook(array $row): Book {
    return new Book($row['id'], $row['title'], $row['image'], $row['author'], $row['description'], $row['pages'], $row['isbn'], $row['genre'], $row['publisher'], $row['format'], $row['publication_date']);
  }

    public static function getBooksByStatus($userId, string $status) : array
    {
        $db = DB::getInstance()->getConnection();
        $statement = $db->prepare("SELECT * FROM books WHERE id IN (SELECT book_id FROM user_books WHERE user_id = ? AND status = ?)");
        $statement->bind_param("is", $userId, $status);
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

}