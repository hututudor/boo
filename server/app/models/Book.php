<?php

class Book {
  public ?int $id;
  public string $title;
  public string $image;
  public string $author;
  public string $description;
  public int $pages;
  public string $isbn;
  public string $genre;
  public string $publisher;
  public string $format;
  public string $publication_date;

  public function __construct($id = null, $title = '', $image = '', $author = '', $description = '', $pages = 0, $isbn = '', $genre = '', $publisher = '', $format = '', $publication_date = '') {
    $this->id = $id;
    $this->title = $title;
    $this->image = $image;
    $this->author = $author;
    $this->description = $description;
    $this->pages = $pages;
    $this->isbn = $isbn;
    $this->genre = $genre;
    $this->publisher = $publisher;
    $this->format = $format;
    $this->publication_date = $publication_date;
  }

  public function getFieldsAsArray() : array
  {
    return array(
      'id' => $this->id,
      'title' => $this->title,
      'author' => $this->author,
      'genre' => $this->genre,
      'pages' => $this->pages,
      'isbn' => $this->isbn,
      'publisher' => $this->publisher,
      'format' => $this->format,
      'publication_date' => $this->publication_date
    );
  }
}