<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About | Boo</title>
  <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
  <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
  <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

  <meta name="page-name" content="about" />
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
    <div class="about">
      <div class="about-container">
        <div class="text text__32 text__bold">About us</div>
        <div class="text text__16">
          Welcome to our web application that aims to help individuals and
          groups keep track of their reading progress and express their
          opinions and annotations on the books they read. With our
          application, users can easily manage their book collections,
          organize them by various criteria such as category, author(s),
          publisher, year, edition, and links to related works. Our platform
          also provides various statistics that can be exported in open
          formats such as CSV and DocBook. Our system keeps users up-to-date
          with the latest news in the literary world through our RSS news
          feed, which provides notifications on new book releases, book
          reviews, changes in book rankings, and more. We are committed to
          providing a user-friendly and efficient reading management system
          that promotes the love of reading and facilitates the sharing of
          ideas and opinions on books. Join us today and discover the joy of
          reading in a whole new way!
        </div>
      </div>
      <div class="about-image">
        <img src="<?php path('assets/about/cover.jpg') ?>" class="w-100" alt="about" />
      </div>
    </div>
  </main>
</body>

</html>