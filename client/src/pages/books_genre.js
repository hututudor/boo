import { listBooksGenre } from '../api';
import { getBookCardNode, renderSidebar } from '../components';

export const load = async () => {
  renderSidebar();

  const urlParams = new URLSearchParams(window.location.search);
  const query = urlParams.get('query');

  if (!query) {
    goTo('..');
  }

  displayQuery(query);
  await displayBooks(query);
};

const displayQuery = query => {
  document.getElementById('query-display').innerHTML = query;
};

const displayBooks = async query => {
  const books = await listBooksGenre(query);

  if (!books.length) {
    return;
  }

  const booksNode = document.getElementsByClassName('books')[0];
  booksNode.innerHTML = '';
  books.forEach(book => booksNode.appendChild(getBookCardNode(book)));
};
