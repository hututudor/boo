import { decodeJWT } from '../utils/jwt';

const TOKEN_KEY = 'token';

export const isAuth = () => {
  const token = localStorage.getItem(TOKEN_KEY);

  if (!token) {
    return false;
  }

  try {
    decodeJWT(token);

    // TODO: check if token is expired here
  } catch (err) {
    _redirectToLogin();
    return false;
  }

  return true;
};

let _currentUserId = null;

export const getCurrentUserId = () => {
  if (!isAuth()) {
    return;
  }

  if (_currentUserId) {
    return _currentUserId;
  }

  const token = localStorage.getItem(TOKEN_KEY);

  if (!token) {
    return false;
  }

  const data = decodeJWT(token);
  _currentUserId = data.id;

  return _currentUserId;
};

let _isAdmin = null;

export const isAdmin = () => {
  if (!isAuth()) {
    return false;
  }

  if (_isAdmin) {
    return _isAdmin;
  }

  const token = localStorage.getItem(TOKEN_KEY);

  if (!token) {
    return false;
  }

  const data = decodeJWT(token);
  _isAdmin = data.isAdmin;

  return _isAdmin;
};

export const logout = () => {
  _isAdmin = null;
  _currentUserId = null;

  localStorage.removeItem(TOKEN_KEY);
  location.reload();
};

export const checkAuth = () => {
  if (!isAuth()) {
    _redirectToLogin();
  }
};

export const checkNoAuth = () => {
  if (isAuth()) {
    _redirectToHome();
  }
};

export const handleLogout = () => {
  _redirectToLogin();
};

export const handleAuth = token => {
  if (!token) {
    return;
  }

  localStorage.setItem(TOKEN_KEY, token);
  _redirectToHome();
};

const _redirectToLogin = () => {
  localStorage.removeItem(TOKEN_KEY);
  goTo('./login');
};

const _redirectToHome = () => goTo('./');
