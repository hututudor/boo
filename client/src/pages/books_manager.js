import { deleteBook, listBooks } from '../api';
import { checkAdmin, checkAuth } from '../app/auth';
import { hideModal, renderSidebar, showModal } from '../components';

const pageState = {
  id: 0,
};

export const load = async () => {
  renderSidebar();
  checkAdmin();

  registerModalEvents();
  await displayBooks();
};

const displayBooks = async () => {
  const books = await listBooks();
  const container = document.getElementsByClassName('books_manager-rows')[0];
  container.innerHTML = '';

  books.forEach(book => container.appendChild(getBookRow(book)));
};

const getBookRow = ({ id, title, author, genre }) => {
  const wrapper = document.createElement('div');

  const idNode = document.createElement('div');
  idNode.innerHTML = id;
  idNode.classList.add('text');
  idNode.classList.add('text__16');

  const titleNode = document.createElement('div');
  titleNode.innerHTML = title;
  titleNode.classList.add('text');
  titleNode.classList.add('text__16');

  const authorNode = document.createElement('div');
  authorNode.innerHTML = author;
  authorNode.classList.add('text');
  authorNode.classList.add('text__16');

  const genreNode = document.createElement('div');
  genreNode.innerHTML = genre;
  genreNode.classList.add('text');
  genreNode.classList.add('text__16');
  genreNode.classList.add('books_manager__mobile-hidden');

  const buttons = document.createElement('div');
  buttons.classList.add('text');
  buttons.classList.add('text__16');

  const edit = document.createElement('button');
  edit.classList.add('button');
  edit.classList.add('button__icon');
  edit.classList.add('mr-2');
  edit.addEventListener('click', () => goTo(`./manager/${id}`));

  const editIcon = document.createElement('i');
  editIcon.classList.add('fa');
  editIcon.classList.add('fa-edit');

  edit.appendChild(editIcon);

  const remove = document.createElement('button');
  remove.classList.add('button');
  remove.classList.add('button__icon');
  remove.classList.add('button__red');
  remove.addEventListener('click', () => {
    pageState.id = id;
    showDeleteBook();
  });

  const removeIcon = document.createElement('i');
  removeIcon.classList.add('fa');
  removeIcon.classList.add('fa-trash');

  remove.appendChild(removeIcon);

  buttons.appendChild(edit);
  buttons.appendChild(remove);

  wrapper.appendChild(idNode);
  wrapper.appendChild(titleNode);
  wrapper.appendChild(authorNode);
  wrapper.appendChild(genreNode);
  wrapper.appendChild(buttons);

  return wrapper;
};

const registerModalEvents = () => {
  document
    .getElementById('delete-modal-cancel')
    .addEventListener('click', hideDeleteBook);
  document
    .getElementById('delete-modal-delete')
    .addEventListener('click', handleDeleteBook);
};

const showDeleteBook = () => {
  showModal('delete-modal');
};

const hideDeleteBook = () => {
  hideModal('delete-modal');
};

const handleDeleteBook = async () => {
  await deleteBook(pageState.id);
  await displayBooks();
  hideDeleteBook();
};
