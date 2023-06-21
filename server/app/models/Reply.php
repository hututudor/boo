<?php

class Reply {
  public ?int $id;
  public int $user_id;
  public int $question_id;
  public string $content;
  public string $date;

  public function __construct($id = null, $user_id = 0, $question_id = 0, $content = '', $date = '') {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->question_id = $question_id;
    $this->content = $content;
    $this->date = $date;
  }
}
