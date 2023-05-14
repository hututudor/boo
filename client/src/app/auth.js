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

export const logout = () => {
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
