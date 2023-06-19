import { API_BASE } from '../config';
import { getAuthToken } from '../app/auth';

export const getAnalytics = async () => {
  const res = await fetch(`${API_BASE}/home/analytics`, {
    headers: { Authorization: getAuthToken() },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};

export const getHomeBooks = async () => {
  const res = await fetch(`${API_BASE}/home/books`, {
    headers: { Authorization: getAuthToken() },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};
