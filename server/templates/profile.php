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

    <meta name="page-name" content="profile" />
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
      <div class="text text__32 text__bold mb-4">Your profile</div>

      <div class="form profile-form">
        <div class="form-input">
          <label for="name">Name</label>
          <input
            id="name"
            name="name"
            placeholder="Your name"
          />
          <span></span>
        </div>
        <div class="form-input">
          <label for="email" type="email">Email</label>
          <input
            id="email"
            name="email"
            placeholder="Your email"
          />
          <span></span>
        </div>

        <div class="flex flex-start">
          <button class="button button__primary" id="form-details-save">Save changes</button>
        </div>
      </div>

      <div class="text text__20 text__bold mt-8 mb-4">Change password</div>
      <div class="form profile-form">
        <div class="form-input">
          <label for="password">Password</label>
          <input
            id="password"
            name="name"
            placeholder="Password"
            type="password"
          />
          <span></span>
        </div>
        <div class="form-input">
          <label for="confirm-password" type="email">Confirm password</label>
          <input
            type="password"
            id="confirm-password"
            name="confirm-password"
            placeholder="Confirm password"
          />
          <span></span>
        </div>

        <div class="flex flex-start">
          <button class="button button__primary" id="form-password-save">Save changes</button>
        </div>
      </div>
    </main>
  </body>
</html>
