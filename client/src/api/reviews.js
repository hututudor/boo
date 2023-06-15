import { API_BASE } from '../config';

export const deleteReview = async id =>
  fetch(`${API_BASE}/reviews/${id}/`, {
    method: 'DELETE',
  });
