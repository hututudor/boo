import { URL_BASE } from '../config';

export const getBookCardNode = ({ id, image, title, author }, base = '.') => {
  const imageNode = document.createElement('div');
  imageNode.classList.add('book_card-image');
  imageNode.style.backgroundImage = `url(${image})`;

  const titleNode = document.createElement('div');
  titleNode.classList.add('text');
  titleNode.classList.add('text__14');
  titleNode.classList.add('text__bold');
  titleNode.innerHTML = title;

  const authorNode = document.createElement('div');
  authorNode.classList.add('text');
  authorNode.classList.add('text__14');
  authorNode.innerHTML = author;

  const container = document.createElement('div');
  container.classList.add('book_card');
  container.addEventListener('click', () => goTo(`${URL_BASE}/books/${id}`));

  container.appendChild(imageNode);
  container.appendChild(titleNode);
  container.appendChild(authorNode);

  return container;
};
