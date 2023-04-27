<?php

class Book {
  public ?int $id;
  public string $title;
  public string $author;
  public int $pages;

  public function __construct($id = null, $title = '', $author = '', $pages = 0) {
    $this->id = $id;
    $this->title = $title;
    $this->author = $author;
    $this->pages = $pages;
  }
}