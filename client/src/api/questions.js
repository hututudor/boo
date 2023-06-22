import { getAuthToken } from '../app/auth';
import { API_BASE } from '../config';

export const listQuestions = async () => {
  const res = await fetch(`${API_BASE}/questions`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const getQuestion = async id => {
  const res = await fetch(`${API_BASE}/questions/${id}`);

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const addQuestion = async ({ title, content }) => {
  const res = await fetch(`${API_BASE}/questions`, {
    method: 'POST',
    body: JSON.stringify({
      title,
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

  return data;
};

export const deleteQuestion = async id =>
  fetch(`${API_BASE}/questions/${id}`, {
    method: 'DELETE',
    headers: {
      Authorization: getAuthToken(),
    },
  });

export const addReply = async ({ id, content }) => {
  const res = await fetch(`${API_BASE}/questions/${id}`, {
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

  return data;
};

export const deleteReply = async id =>
  fetch(`${API_BASE}/replies/${id}`, {
    method: 'DELETE',
    headers: {
      Authorization: getAuthToken(),
    },
  });
