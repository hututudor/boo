import { getBook } from '../api';
import { renderSidebar, loadBookImages } from '../components';

export const load = async () => {
  renderSidebar();
  loadBookImages();

  const book = await getBook(window.bookId);
  showBook(book);
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
