<?php

require_once ROOT_DIR . '/app/models/Review.php';

class ReviewRepository {
  public static function getAll(): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM reviews");
    $statement->execute();

    if($statement->error) {
      return [];
    }

    $reviews = [];
    foreach ($statement->get_result() as $row) {
      $reviews[] = self::toReview($row);
    }

    return $reviews;
  }

  public static function getById(string $id): ?Review {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM reviews WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $row = $statement->get_result()->fetch_assoc();
    if(!$row) {
      return null;
    }

    return self::toReview($row);
  }

  public static function getByBookId(string $bookId): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM reviews WHERE book_id = ?");
    $statement->bind_param("i", $bookId);
    $statement->execute();

    if($statement->error) {
      return [];
    }

    $reviews = [];
    foreach ($statement->get_result() as $row) {
      $reviews[] = self::toReview($row);
    }

    return $reviews;
  }

  public static function insert(Review $review): ?Review {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("INSERT INTO reviews (book_id, user_id, description) VALUES (?, ?, ?)");
    $statement->bind_param("iis", $review->book_id, $review->user_id, $review->description);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $review->id = $statement->insert_id;
    return $review;
  }

  public static function update(Review $review): bool {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("UPDATE reviews SET book_id = ?, user_id = ?, description = ? WHERE id = ?");
    $statement->bind_param("iisi", $review->book_id, $review->user_id, $review->description, $review->id);
    $statement->execute();

    return !!$statement->error;
  }

  public static function deleteById(int $id, int $user_id, int $book_id): void {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("DELETE FROM reviews WHERE id = ? AND user_id = ? AND book_id = ?");
    $statement->bind_param("iii", $id, $user_id, $book_id);
    $statement->execute();
  }

  private static function toReview(array $row): Review {
    return new Review($row['id'], $row['book_id'], $row['user_id'], $row['description']);
  }
}
