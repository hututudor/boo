<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Books manager | Boo</title>
    <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
    <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
    <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

    <script>
        window.bookId = <?php echo $params['id'] ?>
    </script>

    <meta name="page-name" content="books_edit" />
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
    <div class="text text__32 text__bold mb-4">Edit book</div>

    <form class="form book_form">
      <div class="form-input">
        <label for="name">Name</label>
        <input
          type="text"
          id="name"
          name="name"
          placeholder="The name of the book"
        />
        <span></span>
      </div>
      <div class="form-input">
        <label for="author">Author</label>
        <input
          type="text"
          id="author"
          name="author"
          placeholder="The author of the book"
        />
        <span></span>
      </div>
      <div class="form-textarea book_form__full-row">
        <label for="description">Description</label>
        <textarea
          type="text"
          id="description"
          name="description"
          placeholder="The description of the book"
          rows="10"
        ></textarea>
        <span></span>
      </div>
      <div class="form-input">
        <label for="isbn">ISBN</label>
        <input
          type="text"
          id="isbn"
          name="isbn"
          placeholder="The ISBN of the book"
        />
        <span></span>
      </div>
      <div class="form-input">
        <label for="publisher">Publisher</label>
        <input
          type="text"
          id="publisher"
          name="publisher"
          placeholder="The publisher of the book"
        />
        <span></span>
      </div>
      <div class="form-input">
        <label for="pages">Page number</label>
        <input
          type="number"
          id="pages"
          name="pages"
          placeholder="The number of pages of the book"
        />
        <span></span>
      </div>
      <div class="form-input">
        <label for="published">Published Date</label>
        <input
          type="text"
          id="published"
          name="published"
          placeholder="The published date of the book"
        />
        <span></span>
      </div>
      <div class="form-dropdown">
        <label for="format">Format</label>
        <select name="format" id="format">
          <option value="Hardcover">Hardcover</option>
          <option value="Paperback">Paperback</option>
        </select>
        <span></span>
      </div>
      <div class="form-dropdown">
        <label for="genre">Genre</label>
        <select name="genre" id="genre">
          <option value="Fantasy">Fantasy</option>
          <option value="Adventure">Adventure</option>
          <option value="Romance">Romance</option>
          <option value="Dystopian">Dystopian</option>
          <option value="Mystery">Mystery</option>
          <option value="Horror">Horror</option>
          <option value="Thriller">Thriller</option>
          <option value="Science Fiction">Science Fiction</option>
          <option value="Historical Fiction">Historical Fiction</option>
          <option value="For Children">For Children</option>
        </select>
        <span></span>
      </div>

      <div class="form-file">
        <label for="cover">Book Cover</label>
        <div>No file chosen</div>
        <input
          type="file"
          id="cover"
          name="cover"
          accept="image/png, image/jpeg"
        />
        <span></span>
      </div>

      <div></div>

      <div class="flex flex__justify-start">
        <button class="button button__primary" type="submit">Save book</button>
      </div>
    </form>
  </main>
  </body>
</html>
