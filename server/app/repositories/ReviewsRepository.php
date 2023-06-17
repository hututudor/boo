<?php

require_once ROOT_DIR . '/app/models/Reviews.php';

class ReviewsRepository {
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

  public static function getById(int $id): ?Review {
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

  public static function getByUserId($userId): array {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("SELECT * FROM reviews WHERE user_id = ?");
    $statement->bind_param("i", $userId);
    $statement->execute();

    if ($statement->error) {
        return [];
    }

    $reviews = [];
    foreach ($statement->get_result() as $row) {
        $reviews[] = self::toReview($row);
    }

    return $reviews;
}

  public static function getByBookId(int $bookId): array {
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
    $statement = $db->prepare("INSERT INTO reviews (book_id, user_id, content, review_date) VALUES (?, ?, ?, ?)");
    $statement->bind_param("iiss", $review->book_id, $review->user_id, $review->content, $review->review_date);
    $statement->execute();

    if($statement->error) {
      return null;
    }

    $review->id = $statement->insert_id;
    return $review;
  }

  public static function update(Review $review): bool {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("UPDATE reviews SET book_id = ?, user_id = ?, content = ?, review_date = ? WHERE id = ?");
    $statement->bind_param("iissi", $review->book_id, $review->user_id, $review->content, $review->review_date, $review->id);
    $statement->execute();

    return !!$statement->error;
  }

  public static function deleteById(int $id): void {
    $db = DB::getInstance()->getConnection();
    $statement = $db->prepare("DELETE FROM reviews WHERE id = ?");
    $statement->bind_param("i", $id);
    $statement->execute();
  }

  private static function toReview(array $row): Review {
    return new Review($row['id'], $row['book_id'], $row['user_id'], $row['content'], $row['review_date']);
  }
}