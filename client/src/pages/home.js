import { getAnalytics, getHomeBooks } from '../api/analytics';
import { getBookCardNode, renderSidebar } from '../components';

export const load = async () => {
  renderSidebar();

  await displayAnalytics();
  await displayBooks();
};

const displayBooks = async () => {
  const { read, toRead, reading } = await getHomeBooks();

  displayBookRow(read, 'books-read');
  displayBookRow(reading, 'books-progress');
  displayBookRow(toRead, 'books-want-to-read');
};

const displayBookRow = (books, name) => {
  if (!books?.length) {
    document.getElementById(`${name}-wrapper`).style.display = 'none';
    return;
  }

  const booksNode = document.getElementById(name);
  booksNode.innerHTML = '';
  books.forEach(book => booksNode.appendChild(getBookCardNode(book)));
};

const displayAnalytics = async () => {
  const { reading, read, toRead, reviews } = await getAnalytics();
  document.getElementById('analytics-progress').innerHTML = reading;
  document.getElementById('analytics-read').innerHTML = read;
  document.getElementById('analytics-want-to-read').innerHTML = toRead;
  document.getElementById('analytics-reviews').innerHTML = reviews;
};
