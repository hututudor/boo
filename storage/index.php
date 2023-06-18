<?php

// php storage service - acts as an S3 alternative

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: *");

define("ROOT_DIR", dirname(__FILE__));
define("PUBLIC_ASSETS_URL", "http://localhost:8090/www");

function uuid()
{
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(openssl_random_pseudo_bytes(16)), 4));
}

if (!isset($_FILES['file'])) {
  header("HTTP/1.0 400 Bad Request");
  return;
}

$source = $_FILES['file']['tmp_name'];
$source_name = $_FILES['file']['name'];

$name = uuid();

$extension = pathinfo($source_name, PATHINFO_EXTENSION);
if ($extension) {
  $name = $name . '.' . $extension;
}
$target = ROOT_DIR . '/assets/' . $name;

move_uploaded_file($source, $target);

$file = PUBLIC_ASSETS_URL . '/assets/' . $name;
echo json_encode(['file' => $file], JSON_UNESCAPED_SLASHES);
