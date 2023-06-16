<?php

function uuid() {
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(openssl_random_pseudo_bytes(16)), 4));
}

class FileController {
  public function upload() {
    if(!isset($_FILES['file'])) {
      Response::badRequest(['message' => 'file not found']);
      return;
    }

    $source = $_FILES['file']['tmp_name'];
    $source_name = $_FILES['file']['name'];

    $name = uuid();

    $extension = pathinfo($source_name, PATHINFO_EXTENSION);
    if($extension) {
      $name = $name . '.' . $extension ;
    }
    $target = ROOT_DIR . '/public/assets/upload/' . $name;

    move_uploaded_file($source, $target);

    $file = PUBLIC_ASSETS_URL . '/assets/upload/' . $name;
    Response::success(['file' => $file]);
  }
}