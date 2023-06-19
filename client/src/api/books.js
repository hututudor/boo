import { getAuthToken } from '../app/auth';
import { API_BASE } from '../config';

export const listBooks = async () => {
  const res = await fetch(`${API_BASE}/books`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const listBooksSearch = async query => {
  const queryParams = new URLSearchParams({ query });
  const res = await fetch(`${API_BASE}/books/search?${queryParams}`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const listBooksGenre = async query => {
  const queryParams = new URLSearchParams({ query });
  const res = await fetch(`${API_BASE}/books/category?${queryParams}`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const listBooksAuthor = async query => {
  const queryParams = new URLSearchParams({ query });
  const res = await fetch(`${API_BASE}/books/author?${queryParams}`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const getBook = async id => {
  const res = await fetch(`${API_BASE}/books/${id}`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const addBook = async ({
  name,
  author,
  description,
  isbn,
  pages,
  publisher,
  published,
  genre,
  format,
  image,
}) => {
  const res = await fetch(`${API_BASE}/books`, {
    method: 'POST',
    body: JSON.stringify({
      title: name,
      author,
      description,
      publisher,
      isbn,
      pages,
      image,
      genre,
      format,
      publication_date: published,
    }),
    headers: {
      Authorization: getAuthToken(),
    },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const editBook = async ({
  id,
  name,
  author,
  description,
  isbn,
  pages,
  publisher,
  published,
  genre,
  format,
  image,
}) => {
  const res = await fetch(`${API_BASE}/books/${id}`, {
    method: 'PUT',
    body: JSON.stringify({
      title: name,
      author,
      description,
      publisher,
      isbn,
      pages,
      image,
      genre,
      format,
      publication_date: published,
    }),
    headers: {
      Authorization: getAuthToken(),
    },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const deleteBook = async id =>
  fetch(`${API_BASE}/books/${id}`, {
    method: 'DELETE',
    headers: {
      Authorization: getAuthToken(),
    },
  });

export const getBookRecommendations = async id => {
  const res = await fetch(`${API_BASE}/books/${id}/recommendations`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const getBookReviews = async id => {
  const res = await fetch(`${API_BASE}/books/${id}/reviews`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const addBookReview = async (id, { content }) => {
  const res = await fetch(`${API_BASE}/books/${id}/reviews`, {
    method: 'POST',
    body: JSON.stringify({
      content,
    }),
    headers: {
      Authorization: getAuthToken(),
    },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return null;
};

export const getBookStatus = async id => {
  const res = await fetch(`${API_BASE}/books/${id}/readingStatus`, {
    headers: { Authorization: getAuthToken() },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const setBookStatus = async (id, status) => {
  const res = await fetch(`${API_BASE}/books/${id}/readingStatus`, {
    method: 'PUT',
    body: JSON.stringify({
      status,
    }),
    headers: {
      Authorization: getAuthToken(),
    },
  });

  // const data = await res.json();

  // if (!res.ok) {
  //   throw data;
  // }

  return null;
};
