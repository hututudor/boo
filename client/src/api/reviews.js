import { getAuthToken } from '../app/auth';
import { API_BASE } from '../config';

export const deleteReview = async id =>
  fetch(`${API_BASE}/reviews/${id}/`, {
    method: 'DELETE',
    headers: {
      Authorization: getAuthToken(),
    },
  });

export const getMyReviews = async () => {
  const res = await fetch(`${API_BASE}/reviews`, {
    headers: { Authorization: getAuthToken() },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data;
};
