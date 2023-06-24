import { getAnalytics, getHomeBooks } from '../api/analytics';
import {
  checkAuth,
  getAuthToken,
  getCurrentUserId,
  isAdmin,
} from '../app/auth';
import { getBookCardNode, renderSidebar } from '../components';
import { URL_BASE } from '../config';

export const load = async () => {
  renderSidebar();
  checkAuth();

  registerExportButtons();
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

const registerExportButtons = () => {
  if (!isAdmin()) {
    document.getElementById('docbook-button').style.display = 'none';
  }

  document.getElementById('rss-button').addEventListener('click', () => {
    window.open(`${URL_BASE}/api/rss/${getCurrentUserId()}`, '_blank');
  });

  document.getElementById('csv-button').addEventListener('click', () => {
    fetch(`${URL_BASE}/api/csv`, {
      headers: {
        Authorization: getAuthToken(),
      },
    })
      .then(response => response.blob())
      .then(blob => {
        var _url = window.URL.createObjectURL(blob);
        window.open(_url, '_blank').focus();
      })
      .catch(err => {
        console.log(err);
      });
  });

  document.getElementById('docbook-button').addEventListener('click', () => {
    fetch(`${URL_BASE}/api/docbook`, {
      headers: {
        Authorization: getAuthToken(),
      },
    })
      .then(response => response.blob())
      .then(blob => {
        console.log(blob);
        var _url = window.URL.createObjectURL(blob);
        console.log(_url);
        window.open(_url, '_blank').focus();
      })
      .catch(err => {
        console.log(err);
      });
  });
};
