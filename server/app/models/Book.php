<?php

class Book {
  public int $id;
  public string $title;
  public string $image;
  public string $author;
  public int $pages;
  public string $isbn;
  public string $genre;
  public string $publisher;
  public string $format;
  public string $publication_date;

  public function __construct($id = null, $title = '', $image = '', $author = '', $pages = 0, $isbn = '', $genre = '', $publisher = '', $format = '', $publication_date = null) {
    $this->id = $id;
    $this->title = $title;
    $this->image = $image;
    $this->author = $author;
    $this->pages = $pages;
    $this->isbn = $isbn;
    $this->genre = $genre;
    $this->publisher = $publisher;
    $this->format = $format;
    $this->publication_date = $publication_date;
  }
}