import { register } from '../api';
import { disableButton, enableButton, setInputError } from '../components';
import { isEmailValid } from '../utils/validation';
import { checkNoAuth, handleAuth } from '../app/auth';

const pageState = {
  nameTouched: false,
  emailTouched: false,
  passwordTouched: false,
  confirmPasswordTouched: false,
};

export const load = () => {
  checkNoAuth();
  registerRegisterEvents();
};

const registerRegisterEvents = () => {
  const name = document.getElementById('name');
  name.addEventListener('keyup', _validateNameField);
  name.addEventListener('blur', _touchField('name'));
  name.addEventListener('blur', _validateNameField);

  const email = document.getElementById('email');
  email.addEventListener('keyup', _validateEmailField);
  email.addEventListener('blur', _touchField('email'));
  email.addEventListener('blur', _validateEmailField);

  const password = document.getElementById('password');
  password.addEventListener('keyup', _validatePasswordField);
  password.addEventListener('blur', _touchField('password'));
  password.addEventListener('blur', _validatePasswordField);

  const confirmPassword = document.getElementById('confirmPassword');
  confirmPassword.addEventListener('keyup', _validateConfirmPasswordField);
  confirmPassword.addEventListener('blur', _touchField('confirmPassword'));
  confirmPassword.addEventListener('blur', _validateConfirmPasswordField);

  const form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', handleRegister);
};

const handleRegister = async event => {
  event.preventDefault();

  _touchFields();

  const isFormValid = [
    _validateNameField,
    _validateEmailField,
    _validatePasswordField,
    _validateConfirmPasswordField,
  ]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.querySelector('button[type="submit"]');
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');

  disableButton(button);

  const { token } = await register({
    name: nameInput.value,
    email: emailInput.value,
    password: passwordInput.value,
  });

  enableButton(button);
  handleAuth(token);
};

const _validateNameField = () => {
  if (!pageState.nameTouched) {
    return true;
  }

  const input = document.getElementById('name');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Name is required');
    return false;
  }

  setInputError(input, '');
  return true;
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

const _validateConfirmPasswordField = () => {
  if (!pageState.confirmPasswordTouched) {
    return true;
  }

  const input = document.getElementById('confirmPassword');
  const value = input.value;

  if (!value) {
    setInputError(input, 'Confirm Password is required');
    return false;
  }

  const passwordInput = document.getElementById('password');
  const password = passwordInput.value;
  if (password !== value) {
    setInputError(input, 'Password confirmation is incorrect');
    return false;
  }

  setInputError(input, '');
  return true;
};

const _touchFields = () => {
  pageState.nameTouched = true;
  pageState.emailTouched = true;
  pageState.passwordTouched = true;
  pageState.confirmPasswordTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};
