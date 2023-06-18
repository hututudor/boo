import { API_BASE } from '../config';
import { getAuthToken } from '../app/auth';

export const getAnalytics = async id => {
  const res = await fetch(`${API_BASE}/home/analytics`, {
    headers: { Authorization: getAuthToken() },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};
