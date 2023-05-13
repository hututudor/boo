<?php

function path($file): void {
  echo PUBLIC_ASSETS_URL . '/' . $file . '?_=' . microtime();
}

class TemplateManager {
  public static function view(string $name, array $params = null): void {
    require('../templates/' . $name . '.php');
  }
}
