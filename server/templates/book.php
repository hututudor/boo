<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>The Way of Kings - Brandon Sanderson | Boo</title>
  <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
  <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
  <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

  <script>
    window.bookId = <?php echo $params['id'] ?>
  </script>

  <meta name="page-name" content="book" />
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
    <div class="book">
      <div class="book-title-mobile">
        <div class="text text__32 text__bold mt-6" id="title-mobile"></div>
        <div class="book-clickable text text__24" onclick="goTo('./books_author.html')" id="author-mobile">
        </div>
      </div>
      <div class="book-image">
        <img id="image" class="w-100" alt="Book image" />
        <div class="book-status-buttons flex flex__column">
          <button class="button button__secondary">Want To Read</button>
          <button class="button button__primary">Reading</button>
          <button class="button button__secondary">Read</button>
          <button class="button button__secondary">Didn't read</button>
        </div>
        <div class="book-status-login flex flex__column">
          <button class="button button__primary">Login to track progress</button>
        </div>
        </div>
      <div class="book-info">
        <div class="book-title-desktop">
          <div class="text text__32 text__bold" id="title"></div>
          <div class="book-clickable text text__24" onclick="goTo('./books_author.html')" id="author">
          </div>
        </div>
        <p class="text text__14 mt-8" id="description">
        </p>
        <div class="book-details mt-6">
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">Pages</span>
            <span class="text text__12 text__bold" id="pages"></span>
          </div>
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">ISBN</span>
            <span class="text text__12 text__bold" id="isbn"></span>
          </div>
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">Genre</span>
            <span class="text text__12 text__bold book-clickable" onclick="goTo('./books_genre.html')" id="genre"></span>
          </div>
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">Publisher</span>
            <span class="text text__12 text__bold" id="publisher"></span>
          </div>
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">Format</span>
            <span class="text text__12 text__bold" id="format"></span>
          </div>
          <div class="book-detail mb-1">
            <span class="text text__12 mr-1">Published At</span>
            <span class="text text__12 text__bold" id="published-date"></span>
          </div>
        </div>

        <div id="recommendations">
          <div class="text text__20 text__bold mt-6 mb-2">More like this</div>
          <div class="book-related">
          </div>
        </div>

        <div id="add-review">
          <div class="text text__20 text__bold mt-6 mb-2">Review this book</div>
          <form class="form">
            <div class="form-textarea">
              <textarea name="message" rows="5" placeholder="Message" id="content"></textarea>
              <span></span>
            </div>
            <div class="action">
              <button type="submit" class="button button__primary">Post Review</button>
            </div>
          </form>
        </div>


        <div class="text text__20 text__bold mt-6 mb-2">Reviews</div>
        <div class="book-reviews">
        </div>
      </div>
    </div>
  </main>
</body>

</html>