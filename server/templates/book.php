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

        <div class="text text__20 text__bold mt-6 mb-2">More like this</div>
        <div class="book-related">
          <div class="book_card" onclick="goTo('./book.html')">
            <div class="book_card-image" data-src="./assets/books/words_of_radiance.jpeg"></div>
            <div class="text text__14 text__bold">Words Of Radiance</div>
            <div class="text text__14">Brandon Sanderson</div>
          </div>
          <div class="book_card" onclick="goTo('./book.html')">
            <div class="book_card-image" data-src="./assets/books/oathbringer.jpeg"></div>
            <div class="text text__14 text__bold">Oathbringer</div>
            <div class="text text__14">Brandon Sanderson</div>
          </div>
          <div class="book_card" onclick="goTo('./book.html')">
            <div class="book_card-image" data-src="./assets/books/rhythm_of_war.jpeg"></div>
            <div class="text text__14 text__bold">Rhythm Of War</div>
            <div class="text text__14">Brandon Sanderson</div>
          </div>
          <div class="book_card" onclick="goTo('./book.html')">
            <div class="book_card-image" data-src="./assets/books/the_final_empire.jpeg"></div>
            <div class="text text__14 text__bold">The Final Empire</div>
            <div class="text text__14">Brandon Sanderson</div>
          </div>
        </div>

        <div class="text text__20 text__bold mt-6 mb-2">Review this book</div>
        <div class="form">
          <div class="form-textarea">
            <textarea name="message" rows="5" placeholder="Message"></textarea>
          </div>
          <div class="action">
            <button class="button button__primary">Post</button>
          </div>
        </div>

        <div class="text text__20 text__bold mt-6 mb-2">Reviews</div>
        <div class="book-reviews">
          <div class="review">
            <div class="text text__16 text__bold mb-1">
              Anthony Clarke - August 12 2023
            </div>
            <div class="text text__16">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Officiis, alias voluptates ipsum vitae, laudantium error autem
              quis tempore sint at sunt. Alias veniam sequi a ullam quod et
              labore nobis!
            </div>
          </div>
          <div class="review">
            <div class="text text__16 text__bold mb-1">
              Anthony Clarke - August 12 2023
            </div>
            <div class="text text__16">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Officiis, alias voluptates ipsum vitae, laudantium error autem
              quis tempore sint at sunt. Alias veniam sequi a ullam quod et
              labore nobis!
            </div>
          </div>
          <div class="review">
            <div class="text text__16 text__bold mb-1">
              Anthony Clarke - August 12 2023
            </div>
            <div class="text text__16">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Officiis, alias voluptates ipsum vitae, laudantium error autem
              quis tempore sint at sunt. Alias veniam sequi a ullam quod et
              labore nobis!
            </div>
          </div>
          <div class="review">
            <div class="text text__16 text__bold mb-1">
              Anthony Clarke - August 12 2023
            </div>
            <div class="text text__16">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Officiis, alias voluptates ipsum vitae, laudantium error autem
              quis tempore sint at sunt. Alias veniam sequi a ullam quod et
              labore nobis!
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>