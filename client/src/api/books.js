import { API_BASE } from '../config';

export const listBooks = async () => {
  const res = await fetch(`${API_BASE}/books`);

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

export const getBookReviews = async id => {
  const res = await fetch(`${API_BASE}/books/${id}/reviews`);

  // const data = await res.json();

  // if (!res.ok) {
  //   throw data;
  // }

  return [
    {
      id: 1,
      user: { name: 'Tudor Hutu', id: 1 },
      createdAt: 'August 12 2023',
      content: 'epic book',
    },
    {
      id: 2,
      user: { name: 'Marcel', id: 2 },
      createdAt: 'August 11 2023',
      content: 'nice',
    },
    {
      id: 3,
      user: { name: 'Victor', id: 4 },
      createdAt: 'October 11 2022',
      content: 'kinda boring :(',
    },
  ];
};

export const addBookReview = async (id, { content }) => {
  const res = await fetch(`${API_BASE}/books/${id}/reviews`, {
    method: 'POST',
    body: JSON.stringify({
      content,
    }),
  });

  // const data = await res.json();

  // if (!res.ok) {
  //   throw data;
  // }

  return null;
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
  });

export const uploadImage = async file => {
  const formData = new FormData();
  formData.append('file', file);

  const res = await fetch(`${API_BASE}/upload`, {
    method: 'POST',
    body: formData,
  });

  const data = await res.json();

  return data.file;
};
