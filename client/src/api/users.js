import { getAuthToken } from '../app/auth';
import { API_BASE } from '../config';

export const getProfile = async () => {
  const res = await fetch(`${API_BASE}/profile`, {
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

export const updateUserEmail = async ({ email }) => {
  const res = await fetch(`${API_BASE}/profile/email`, {
    method: 'PUT',
    body: JSON.stringify({
      email,
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

export const updateUserName = async ({ name }) => {
  const res = await fetch(`${API_BASE}/profile/name`, {
    method: 'PUT',
    body: JSON.stringify({
      full_name: name,
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

export const updateUserPassword = async ({ password }) => {
  const res = await fetch(`${API_BASE}/profile/password`, {
    method: 'PUT',
    body: JSON.stringify({
      password,
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

export const listUsers = async () => {
  const res = await fetch(`${API_BASE}/users`, {
    headers: {
      Authorization: getAuthToken(),
    },
  });

  const data = await res.json();

  if (!res.ok) {
    throw data;
  }

  return data.users;
};

export const deleteUser = async id =>
  fetch(`${API_BASE}/users/${id}`, {
    method: 'DELETE',
    headers: {
      Authorization: getAuthToken(),
    },
  });

export const promoteUser = async id =>
  fetch(`${API_BASE}/users/${id}/promote`, {
    method: 'PUT',
    headers: {
      Authorization: getAuthToken(),
    },
  });

export const demoteUser = async id =>
  fetch(`${API_BASE}/users/${id}/demote`, {
    method: 'PUT',
    headers: {
      Authorization: getAuthToken(),
    },
  });
