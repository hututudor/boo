<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All books | Boo</title>
  <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
  <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
  <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

  <meta name="page-name" content="reviews" />
  <script src="<?php path('scripts/app.js') ?>"></script>
  <script src="<?php path('goTo.js') ?>"></script>
</head>

<body>
  <div class="loading" id="loading">
    <img src="<?php path('assets/loading.gif') ?>" alt="logo" />
  </div>

  <div class="modal modal__hidden" id="delete-modal">
    <div class="modal-content">
      <div class="text text__32 text__bold mb-2">Delete Review</div>
      <div class="text text__16 mb-8">Are you sure? This operation cannot be reverted</div>
      <div class="flex flex__justify-center">
        <button class="button button__secondary mr-4" id="delete-modal-cancel">Cancel</button>
        <button class="button button__primary button__red" id="delete-modal-delete">Delete</button>
      </div>
    </div>
  </div>

  <nav>
    <button>
      <i class="fa fa-arrow-right" aria-hidden="true"></i>
    </button>
  </nav>

  <aside class="side">
    <div class="side-logo">
      <img src="<?php path('assets/logo_white.svg') ?>" alt="logo" />
    </div>
    <div class="side-search">
      <input type="text" id="search" placeholder="Search" />
      <i class="fa fa-search" aria-hidden="true"></i>
    </div>
    <div class="side-links">
    </div>
    <div class="side-footer">
      <div class="text text__14">boo @ 2023</div>
    </div>
  </aside>

  <main>
    <div class="text text__32 text__bold mb-4">My Reviews</div>
    <div class="reviews">
    </div>
  </main>
  </body>
</html>
