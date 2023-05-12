import { API_BASE } from '../config';

export const login = async ({ email, password }) => {
  const res = await fetch(`${API_BASE}/auth/login`, {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      email,
      password,
    }),
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const register = async ({ email, name, password }) => {
  const res = await fetch(`${API_BASE}/auth/register`, {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      fullName: name,
      email,
      password,
    }),
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};
