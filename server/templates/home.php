<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home | Boo</title>
    <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
    <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
    <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

    <meta name="page-name" content="home" />
    <script src="<?php path('scripts/app.js') ?>"></script>
    <script src="<?php path('goTo.js') ?>"></script>
  </head>

  <body>
    <div class="loading" id="loading">
      <img src="<?php path('assets/loading.gif') ?>" alt="logo" />
    </div>

    <nav>
      <button>
        <i class="fa fa-arrow-right" aria-hidden="true"></i>
      </button>
    </nav>

  <aside class="side">
    <div class="side-logo">
      <img src="assets/logo_white.svg" alt="logo" />
    </div>
    <div class="side-search">
      <input type="text" id="search" placeholder="Search" />
      <i class="fa fa-search" aria-hidden="true"></i>
    </div>
    <div class="side-links"></div>
    <div class="side-footer">
      <div class="text text__14">boo @ 2023</div>
    </div>
  </aside>

  <main>
    <div class="home">
      <div class="text text__32 text__bold mb-4">Your habits in numbers</div>
      <div class="home-analytics">
        <button class="button button__icon-large mr-4">
          <i class="fa fa-rss"></i>
        </button>
        <button class="button button__primary mr-4">Download CSV</button>
        <button class="button button__primary">Download DocBook</button>
      </div>
    </div>
    <div class="stats mb-8">
      <div class="stat">
        <span class="text text__20 text__bold text__primary mr-1" id="analytics-progress">0</span>
        <span class="text text__16">books in progress</span>
      </div>
      <div class="stat">
        <span class="text text__20 text__bold text__primary mr-1" id="analytics-read">0</span>
        <span class="text text__16">books read</span>
      </div>
      <div class="stat">
        <span class="text text__20 text__bold text__primary mr-1" id="analytics-want-to-read">0</span>
        <span class="text text__16">books you want to read</span>
      </div>
      <div class="stat">
        <span class="text text__20 text__bold text__primary mr-1" id="analytics-reviews">0</span>
        <span class="text text__16">reviews left</span>
      </div>
    </div>

    <div class="text text__20 text__bold text__primary mb-4">In progress</div>
    <div class="books">
      <div class="book_card" onclick="goTo('./book.html')">
        <div
          class="book_card-image"
          data-src="./assets/books/words_of_radiance.jpeg"
        ></div>
        <div class="text text__14 text__bold">Words Of Radiance</div>
        <div class="text text__14">Brandon Sanderson</div>
      </div>
    </div>
    <div class="text text__20 text__bold text__primary mb-4">
      Want to read
    </div>
    <div class="books">
      <div class="book_card" onclick="goTo('./book.html')">
        <div
          class="book_card-image"
          data-src="./assets/books/the_hero_of_ages.jpeg"
        ></div>
        <div class="text text__14 text__bold">The Hero Of Ages</div>
        <div class="text text__14">Brandon Sanderson</div>
      </div>
      <div class="book_card" onclick="goTo('./book.html')">
        <div
          class="book_card-image"
          data-src="./assets/books/the_alloy_of_law.jpeg"
        ></div>
        <div class="text text__14 text__bold">The Alloy Of Law</div>
        <div class="text text__14">Brandon Sanderson</div>
      </div>
    </div>
    <div class="text text__20 text__bold text__primary mb-4">Read</div>
    <div class="books">
      <div class="book_card" onclick="goTo('./book.html')">
        <div
          class="book_card-image"
          data-src="./assets/books/oathbringer.jpeg"
          alt="words of radiance"
        ></div>
        <div class="text text__14 text__bold">Oathbringer</div>
        <div class="text text__14">Brandon Sanderson</div>
      </div>
      <div class="book_card" onclick="goTo('./book.html')">
        <div
          class="book_card-image"
          data-src="./assets/books/rhythm_of_war.jpeg"
        ></div>
        <div class="text text__14 text__bold">Rhythm Of War</div>
        <div class="text text__14">Brandon Sanderson</div>
      </div>
    </div>
  </main>
  </body>
</html>
