<?php

class Question {
  public ?int $id;
  public int $user_id;
  public string $title;
  public string $content;
  public string $date;
  public int $view_count;
  public int $reply_count;

  public function __construct($id = null, $user_id = 0, $title = '', $content = '', $date = '', $view_count = 0, $reply_count = 0) {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->title = $title;
    $this->content = $content;
    $this->date = $date;
    $this->view_count = $view_count;
    $this->reply_count = $reply_count;
  }
}
