<?php

class Review {
  public ?int $id;
  public int $book_id;
  public int $user_id;
  public string $description;

  public function __construct($id = null, $book_id = 0, $user_id = 0, $description = '') {
    $this->id = $id;
    $this->book_id = $book_id;
    $this->user_id = $user_id;
    $this->description = $description;
  }
}