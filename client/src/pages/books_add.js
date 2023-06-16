import { addBook, uploadImage } from '../api';
import { checkAuth } from '../app/auth';
import {
  disableButton,
  enableButton,
  loadFormFiles,
  renderSidebar,
  setInputError,
} from '../components';

const pageState = {
  nameTouched: false,
  authorTouched: false,
  descriptionTouched: false,
  isbnTouched: false,
  publisherTouched: false,
  pagesTouched: false,
  publishedTouched: false,
  formatTouched: false,
  genreTouched: false,
  coverTouched: false,
};

export const load = () => {
  renderSidebar();
  checkAuth();

  loadFormFiles();

  registerFormEvents();
};

const registerFormEvents = () => {
  const name = document.getElementById('name');
  name.addEventListener('keyup', _validateNameField);
  name.addEventListener('blur', _touchField('name'));
  name.addEventListener('blur', _validateNameField);

  const author = document.getElementById('author');
  author.addEventListener('keyup', _validateAuthorField);
  author.addEventListener('blur', _touchField('author'));
  author.addEventListener('blur', _validateAuthorField);

  const description = document.getElementById('description');
  description.addEventListener('keyup', _validateDescriptionField);
  description.addEventListener('blur', _touchField('description'));
  description.addEventListener('blur', _validateDescriptionField);

  const isbn = document.getElementById('isbn');
  isbn.addEventListener('keyup', _validateISBNField);
  isbn.addEventListener('blur', _touchField('isbn'));
  isbn.addEventListener('blur', _validateISBNField);

  const publisher = document.getElementById('publisher');
  publisher.addEventListener('keyup', _validatePublisherField);
  publisher.addEventListener('blur', _touchField('publisher'));
  publisher.addEventListener('blur', _validatePublisherField);

  const pages = document.getElementById('pages');
  pages.addEventListener('keyup', _validatePagesField);
  pages.addEventListener('blur', _touchField('pages'));
  pages.addEventListener('blur', _validatePagesField);

  const published = document.getElementById('published');
  published.addEventListener('keyup', _validatePublishedField);
  published.addEventListener('blur', _touchField('published'));
  published.addEventListener('blur', _validatePublishedField);

  const format = document.getElementById('format');
  format.addEventListener('keyup', _validateFormatField);
  format.addEventListener('blur', _touchField('format'));
  format.addEventListener('blur', _validateFormatField);

  const genre = document.getElementById('genre');
  genre.addEventListener('keyup', _validateGenreField);
  genre.addEventListener('blur', _touchField('genre'));
  genre.addEventListener('blur', _validateGenreField);

  const cover = document.getElementById('cover');
  cover.addEventListener('change', _validateCoverField);
  cover.addEventListener('blur', _touchField('cover'));
  cover.addEventListener('blur', _validateCoverField);

  const form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', handleAddBook);
};

const handleAddBook = async event => {
  event.preventDefault();

  _touchFields();

  const isFormValid = [
    _validateNameField,
    _validateAuthorField,
    _validateDescriptionField,
    _validateISBNField,
    _validatePublisherField,
    _validatePagesField,
    _validatePublishedField,
    _validateFormatField,
    _validateGenreField,
    _validateCoverField,
  ]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.querySelector('button[type="submit"]');

  disableButton(button);

  try {
    const image = await uploadImage(cover.files[0]);

    await addBook({
      name: document.getElementById('name').value,
      author: document.getElementById('author').value,
      description: document.getElementById('description').value,
      isbn: document.getElementById('isbn').value,
      publisher: document.getElementById('publisher').value,
      pages: document.getElementById('pages').value,
      published: document.getElementById('published').value,
      format: document.getElementById('format').value,
      genre: document.getElementById('genre').value,
      image,
    });
  } finally {
    enableButton(button);
  }

  goTo('../manager');
};

const _validateNameField = () => {
  if (!pageState.nameTouched) {
    return true;
  }

  const input = document.getElementById('name');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Name is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateAuthorField = () => {
  if (!pageState.authorTouched) {
    return true;
  }

  const input = document.getElementById('author');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Author is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateISBNField = () => {
  if (!pageState.isbnTouched) {
    return true;
  }

  const input = document.getElementById('isbn');
  const value = input.value;

  if (!value) {
    setInputError(input, 'ISBN is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateDescriptionField = () => {
  if (!pageState.descriptionTouched) {
    return true;
  }

  const input = document.getElementById('description');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Description is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validatePublisherField = () => {
  if (!pageState.publisherTouched) {
    return true;
  }

  const input = document.getElementById('publisher');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Publisher is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validatePagesField = () => {
  if (!pageState.pagesTouched) {
    return true;
  }

  const input = document.getElementById('pages');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Pages is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validatePublishedField = () => {
  if (!pageState.publishedTouched) {
    return true;
  }

  const input = document.getElementById('published');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Published Date is required');
    return false;
  }

  const regex = /\d{2}.\d{2}.\d{4}/;
  if (!regex.test(value)) {
    setInputError(input, 'Published Date must have the format 23.10.2020');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateFormatField = () => {
  if (!pageState.formatTouched) {
    return true;
  }

  const input = document.getElementById('format');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Format is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateGenreField = () => {
  if (!pageState.genreTouched) {
    return true;
  }

  const input = document.getElementById('genre');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Genre is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validateCoverField = () => {
  if (!pageState.coverTouched) {
    return true;
  }

  const input = document.getElementById('cover');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Cover is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.nameTouched = true;
  pageState.authorTouched = true;
  pageState.descriptionTouched = true;
  pageState.isbnTouched = true;
  pageState.publisherTouched = true;
  pageState.pagesTouched = true;
  pageState.publishedTouched = true;
  pageState.formatTouched = true;
  pageState.genreTouched = true;
  pageState.coverTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};
