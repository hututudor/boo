import { listBooks } from '../api';
import { renderSidebar, getBookCardNode } from '../components';

export const load = async () => {
  renderSidebar();

  const books = await listBooks();

  const booksNode = document.getElementsByClassName('books')[0];
  books.forEach(book => booksNode.appendChild(getBookCardNode(book)));
};
