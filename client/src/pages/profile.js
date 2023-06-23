import {
  getProfile,
  updateUserEmail,
  updateUserName,
  updateUserPassword,
} from '../api/users';
import { checkAuth } from '../app/auth';
import {
  disableButton,
  enableButton,
  renderSidebar,
  setInputError,
} from '../components';
import { isEmailValid } from '../utils/validation';

const pageState = {
  nameTouched: false,
  emailTouched: false,
  passwordTouched: false,
  confirmPasswordTouched: false,
};

export const load = async () => {
  renderSidebar();
  checkAuth();

  await displayProfile();
  registerFormEvents();
};

const displayProfile = async () => {
  const profile = await getProfile();

  fillForm(profile);
};

const fillForm = ({ name, email }) => {
  document.getElementById('name').value = name;
  document.getElementById('email').value = email;
};

const registerFormEvents = () => {
  document
    .getElementById('form-details-save')
    .addEventListener('click', handleFormDetailsSubmit);

  document
    .getElementById('form-password-save')
    .addEventListener('click', handleFormPasswordSubmit);

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

  const confirmPassword = document.getElementById('confirm-password');
  confirmPassword.addEventListener('keyup', _validateConfirmPasswordField);
  confirmPassword.addEventListener('blur', _touchField('confirmPassword'));
  confirmPassword.addEventListener('blur', _validateConfirmPasswordField);
};

const handleFormDetailsSubmit = async () => {
  _touchDetailsFields();

  const isFormValid = [_validateNameField, _validateEmailField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.getElementById('form-details-save');

  disableButton(button);

  try {
    await updateUserEmail({
      email: document.getElementById('email').value,
    });

    await updateUserName({
      name: document.getElementById('name').value,
    });
  } catch (err) {
    if (err?.message) {
      setInputError(document.getElementById('email'), err.message);
    }

    enableButton();
    return;
  } finally {
    enableButton(button);
  }

  await displayProfile();
};

const handleFormPasswordSubmit = async () => {
  _touchPasswordFields();

  const isFormValid = [_validatePasswordField, _validateConfirmPasswordField]
    .map(validator => validator())
    .every(result => !!result);

  if (!isFormValid) {
    return;
  }

  const button = document.getElementById('form-password-save');

  disableButton(button);

  try {
    await updateUserPassword({
      password: document.getElementById('password').value,
    });
  } finally {
    enableButton(button);
  }

  document.getElementById('password').value = '';
  document.getElementById('confirm-password').value = '';
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

  const input = document.getElementById('confirm-password');
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

const _touchDetailsFields = () => {
  pageState.nameTouched = true;
  pageState.emailTouched = true;
};

const _touchPasswordFields = () => {
  pageState.passwordTouched = true;
  pageState.confirmPasswordTouched = true;
};

const _touchField = name => () => {
  const key = `${name}Touched`;
  pageState[key] = true;
};
