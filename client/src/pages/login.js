import { login } from '../api';
import { disableButton, enableButton, setInputError } from '../components';
import { isEmailValid } from '../utils/validation';

const pageState = {
  emailTouched: false,
  passwordTouched: false,
};

export const load = () => {
  registerLoginEvents();
};

const registerLoginEvents = () => {
  const email = document.getElementById('email');
  email.addEventListener('keyup', _validateEmailField);
  email.addEventListener('blur', _touchField('email'));
  email.addEventListener('blur', _validateEmailField);

  const password = document.getElementById('password');
  password.addEventListener('keyup', _validatePasswordField);
  password.addEventListener('blur', _touchField('password'));
  password.addEventListener('blur', _validatePasswordField);

  const form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', handleLogin);
};

const handleLogin = async event => {
  event.preventDefault();

  _touchFields();

  const isFormValid = [_validateEmailField, _validatePasswordField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.querySelector('button[type="submit"]');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');

  disableButton(button);

  const data = await login({
    email: emailInput.value,
    password: passwordInput.value,
  });

  enableButton(button);

  localStorage.setItem('token', data.token);
};

const _validateEmailField = () => {
  if (!pageState.emailTouched) {
    return true;
  }

  const input = document.getElementById('email');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Email is required');
    return false;
  }

  if (!isEmailValid(input.value)) {
    setInputError(input, 'Email must be valid');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _validatePasswordField = () => {
  if (!pageState.passwordTouched) {
    return true;
  }

  const input = document.getElementById('password');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Password is required');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.emailTouched = true;
  pageState.passwordTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};
