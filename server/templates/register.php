<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
    <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

    <meta name="page-name" content="register" />
    <script src="<?php path('scripts/app.js') ?>"></script>
    <script src="<?php path('goTo.js') ?>"></script>
  </head>

  <body>
  <div class="loading" id="loading">
    <img src="<?php path('assets/loading.gif') ?>" alt="logo" />
  </div>

    <div class="auth">
      <div class="auth-container">
        <img class="auth-container-logo" src="<?php path('assets/logo.svg') ?>" alt="logo" />
        <div class="text text__32 text__bold text__center mb-4">Register</div>
        <form class="form w-100">
          <div class="form-input">
            <label for="name">Name</label>
            <input id="name" placeholder="Name" />
            <span></span>
          </div>
          <div class="form-input">
            <label for="email">Email</label>
            <input id="email" placeholder="Email" />
            <span></span>
          </div>
          <div class="form-input">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Password" />
            <span></span>
          </div>
          <div class="form-input">
            <label for="confirmPassword">Confirm password</label>
            <input
              type="password"
              id="confirmPassword"
              placeholder="Confirm password"
            />
            <span></span>
          </div>
          <div id="error" class="text text__16 text__center w-100"></div>
          <div class="flex flex__column flex__align-center mt-4">
            <button class="button button__primary" type="submit">
              Register
            </button>
            <button
              class="button button__link mt-4"
              onclick="goTo('./login')"
              type="button"
            >
              Already have an account? Login.
            </button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
