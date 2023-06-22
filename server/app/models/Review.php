<?php

class Review {
  public ?int $id;
  public int $book_id;
  public int $user_id;
  public string $content;
  public string $review_date;

  public function __construct($id = null, $book_id = 0, $user_id = 0, $content = '', $review_date = '') {
    $this->id = $id;
    $this->book_id = $book_id;
    $this->user_id = $user_id;
    $this->content = $content;
    $this->review_date = $review_date;
  }
}