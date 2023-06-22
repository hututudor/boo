<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Help | Boo</title>
  <link rel="stylesheet" href="<?php path('fork-awesome.css'); ?>" />
  <link rel="stylesheet" href="<?php path('styles/index.css') ?>" />
  <link rel="shortcut icon" href="<?php path('assets/favicon.ico') ?>" type="image/x-icon" />

  <meta name="page-name" content="help" />
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

  <div class="modal modal__hidden" id="delete-modal">
    <div class="modal-content">
      <div class="text text__32 text__bold mb-2">Delete Question</div>
      <div class="text text__16 mb-8">Are you sure? This operation cannot be reverted</div>
      <div class="flex flex__justify-center">
        <button class="button button__secondary mr-4" id="delete-modal-cancel">Cancel</button>
        <button class="button button__primary button__red" id="delete-modal-delete">Delete</button>
      </div>
    </div>
  </div>

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
    <div class="help">
      <div class="text text__32 text__bold">Frequently asked questions</div>
      <div class="help-container">
        <div class="help-container-questions">
          <div class="help-container-questions-list">
            <div class="question_card" onclick="goTo('./help_question.html')">
              <div class="text text__16 text__bold">How to add a book ?</div>
              <div class="question_card-specifications">
                <div class="question_card-specifications-details">
                  <div class="question_card-specifications-element">
                    <div class="text text__14">Johnathan - 20.05.2002</div>
                  </div>
                </div>
                <div class="question_card-specifications-statistics">
                  <div class="question_card-specifications-element">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    <div class="text text__14">42</div>
                  </div>
                  <div class="question_card-specifications-element">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    <div class="text text__14">8.2k</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="help-container-form" id="response-form">
          <div class="text text__24 text__bold mb-5">Ask a question</div>
          <div class="form">
            <div class="form-input">
              <input
                type="text"
                id="title"
                name="name"
                placeholder="Title"
              />
              <span></span>
            </div>
            <div class="form-textarea">
              <textarea name="message" rows="10" placeholder="Message" id="content"></textarea>
              <span></span>
            </div>
            <div class="action">
              <button class="button button__primary" id="post-button">Post</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>