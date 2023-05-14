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
