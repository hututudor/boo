import { addBookReview, deleteReview, getBook, getBookReviews } from '../api';
import {
  renderSidebar,
  loadBookImages,
  getReviewNode,
  showModal,
  hideModal,
  setInputError,
  disableButton,
  enableButton,
} from '../components';

const pageState = {
  id: 0,
  reviewId: 0,
  contentTouched: false,
};

export const load = async () => {
  renderSidebar();
  loadBookImages();

  pageState.id = window.bookId;

  const book = await getBook(pageState.id);
  showBook(book);

  displayReviews();
  registerModalEvents();
  registerFormEvents();
};

const displayReviews = async () => {
  const reviews = await getBookReviews(pageState.id);
  showReviews(reviews);
};

const showReviews = reviews => {
  const reviewsNode = document.getElementsByClassName('book-reviews')[0];
  reviewsNode.innerHTML = '';
  reviews.forEach(review =>
    reviewsNode.appendChild(getReviewNode(review, showDeleteReview(review.id))),
  );
};

const showBook = book => {
  document.getElementById('image').src = book.image;
  document.getElementById('author-mobile').innerHTML = book.author;
  document.getElementById('title-mobile').innerHTML = book.title;
  document.getElementById('author').innerHTML = book.author;
  document.getElementById('title').innerHTML = book.title;
  document.getElementById('description').innerHTML = book.description;
  document.getElementById('pages').innerHTML = book.pages;
  document.getElementById('isbn').innerHTML = book.isbn;
  document.getElementById('genre').innerHTML = book.genre;
  document.getElementById('publisher').innerHTML = book.publisher;
  document.getElementById('format').innerHTML = book.format;
  document.getElementById('published-date').innerHTML = book.publication_date;
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteReview);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteReview);
};

const showDeleteReview = reviewId => () => {
  pageState.reviewId = reviewId;
  showModal('delete-modal');
};

const hideDeleteReview = () => {
  hideModal('delete-modal');
};

const handleDeleteReview = async () => {
  await deleteReview(pageState.reviewId);
  await displayReviews();
  hideDeleteReview();
};

const registerFormEvents = () => {
  const content = document.getElementById('content');
  content.addEventListener('keyup', _validateContentField);
  content.addEventListener('blur', _touchField('content'));
  content.addEventListener('blur', _validateContentField);

  const form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', handleAddReview);
};

const handleAddReview = async () => {
  event.preventDefault();

  _touchFields();

  const isFormValid = [_validateContentField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.querySelector('button[type="submit"]');

  disableButton(button);

  try {
    await addBookReview(pageState.id, {
      content: document.getElementById('content').value,
    });

    pageState.contentTouched = false;
    document.getElementById('content').value = '';
  } finally {
    enableButton(button);
  }

  await displayReviews();
};

const _validateContentField = () => {
  if (!pageState.contentTouched) {
    return true;
  }

  const input = document.getElementById('content');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Message is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.contentTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};
