<?php

require_once ROOT_DIR . '/app/TemplateManager.php';

class ViewController {
  public function login(): void {
    TemplateManager::view('login');
  }

  public function register(): void {
    TemplateManager::view('register');
  }

  public function about(): void {
    TemplateManager::view('about');
  }

  public function help(): void {
    TemplateManager::view('help');
  }

  public function books(): void {
    TemplateManager::view('books');
  }

  public function book(Request $request): void {
    TemplateManager::view('book', $request->params);
  }

  public function manager(): void {
    TemplateManager::view('books_manager');
  }

  public function managerAdd(): void {
    TemplateManager::view('books_add');
  }

  public function managerEdit(Request $request): void {
    TemplateManager::view('books_edit', $request->params);
  }

}
